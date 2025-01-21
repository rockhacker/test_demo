package fundSubscription

import (
	"encoding/json"
	"exchange_features/database"
	"gorm.io/gorm"
	"log"
	"math/big"
	"strconv"
	"strings"
	"time"
)

type SetCommission struct {
}

func RunServer() *SetCommission {
	db := database.DB
	t := time.NewTicker(60 * time.Second)

	go onWorker(t.C, db)

	go func() {

		for {

			var funds []database.Funds
			res := db.Where("status = ? and start_time <= ?", database.FundsSubscription, time.Now().Format("2006-01-02 15:04:05")).Find(&funds)

			if res.Error != nil {
				time.Sleep(time.Second * 2)
				log.Println(res.Error.Error())
				continue
			}

			for _, val := range funds {
				timePeriods := val.LockDividendDays / val.LockDividendCount

				_ = db.Transaction(func(tx *gorm.DB) error {
					result := tx.Model(val).Where("id = ?", val.Id).Update("status", database.FundsToBeSubscribed)

					if result.Error != nil {

						return result.Error
					}

					for i := 1; i <= val.LockDividendCount; i++ {

						periods := database.FundsPeriods{}
						periods.Status = 1
						periods.FundId = val.Id
						periods.GrantInterest = 0
						periods.GrantSendTime = val.OverTime.AddDate(0, 0, timePeriods*i)
						periods.PeriodsNumber = strconv.Itoa(i) + "#" + val.OverTime.AddDate(0, 0, timePeriods*i).Format("20060102")
						periods.EachDividend = val.DividendPercentage

						result = tx.Create(&periods)

						if result.Error != nil {

							return result.Error
						}
					}

					return nil
				})
			}

			time.Sleep(time.Second * 2)
		}
	}()

	return new(SetCommission)
}

func (SetCommission) RunCommission() {

	db := database.DB
	sleep := time.Second * 10
	for {

		setting := database.SetCommission{}

		//开启反佣的反佣数据
		res := db.Where("id = 1 and status = 1").First(&setting)

		if res.Error != nil {

			time.Sleep(sleep)
			continue
		}
		var level map[int]interface{}

		err := json.Unmarshal([]byte(setting.Levels), &level)

		if err != nil {

			time.Sleep(sleep)
			log.Println(err.Error())
			continue
		}

		err = db.Transaction(func(tx *gorm.DB) error {

			periods := database.FundsPeriods{}

			//找一条已发放佣金并且未反佣的数据
			res := tx.Where("is_fy = ? and status = ?", 0, 2).First(&periods)

			if res.Error != nil {

				return res.Error
			}

			//是否反佣
			if setting.Status == 1 {

				fund := database.Funds{}

				res = tx.Where("id = ?", periods.FundId).First(&fund)

				if res.Error != nil {

					return res.Error
				}

				var interest []database.InterestFunds

				res = tx.Where("periods_id = ?", periods.Id).Find(&interest)

				if res.Error != nil {

					return res.Error
				}

				for _, v := range interest {

					user := database.Users{}

					res = tx.Where("id = ?", v.UserId).Select("id", "parent_id").First(&user)

					if res.Error != nil {

						return res.Error
					}

					//如果没有找到上级直接结束
					if user.ParentId == 0 {

						return nil
					}
					parentId := user.ParentId

					//开始反佣
					for i := 1; i <= len(level); i++ {

						if parentId == 0 {

							break
						}

						parentUser := database.Users{}

						res = tx.Where("id = ?", parentId).Select("id", "parent_id").First(&parentUser)

						if res.RowsAffected == 0 || res.Error != nil {

							return res.Error
						}

						parentId = parentUser.ParentId

						account, err := database.NewChangeAccount(tx).GetAccount(fund.CurrencyId, int64(parentUser.Id))

						if err != nil {

							return err
						}
						//更精准的小数位运算，消耗较多资源
						float64Bili, err := strconv.ParseFloat(level[i].(string), 10)
						//initBili := new(big.Float).SetFloat64(float64Bili / 100)
						//amount := new(big.Float).Mul(new(big.Float).SetFloat64(v.Interest),initBili)

						amount := v.Interest * (float64Bili / 100)

						err = account.ChangeBalance(database.FundCommission, amount)

						if err != nil {

							return err
						}

						saveLog := database.FundCommissionLists{}
						saveLog.UserId = int64(parentUser.Id)
						saveLog.CreatedAt = time.Now()
						saveLog.Amount = amount
						saveLog.CommissionLevel = i
						saveLog.CommissionSetData = setting.Levels
						saveLog.ForPeriodsId = periods.Id
						saveLog.ForFundId = fund.Id
						saveLog.ForSubId = v.SubId
						saveLog.ForUserId = v.UserId
						res = tx.Create(saveLog)

						if res.Error != nil {

							return res.Error
						}

						res = tx.Model(database.FundsPeriods{}).Where("id = ?", periods.Id).Updates(map[string]interface{}{
							"is_fy": 1, //反佣已结束
						})
						if res.Error != nil {

							return res.Error
						}
					}

				}

			} else {

				res = tx.Model(database.FundsPeriods{}).Where("id = ?", periods.Id).Updates(map[string]interface{}{
					"is_fy": 1, //反佣已结束
				})
				if res.Error != nil {

					return res.Error
				}
			}

			return nil
		})

		if err != nil {

			time.Sleep(sleep)
			continue
		}

		time.Sleep(sleep)
	}
}

func onWorker(t <-chan time.Time, db *gorm.DB) {

	for {

		select {
		case <-t:
			var periods []database.FundsPeriods

			initializeTime := time.Now().Format("2006-01-02")

			startTime := initializeTime + " 00:00:00"
			endTime := initializeTime + " 23:59:59"

			err := db.Transaction(func(tx *gorm.DB) error {

				res := tx.Where("grant_send_time >= ? and grant_send_time <= ?", startTime, endTime).Where("status = ? ", 1).Find(&periods)

				if res.Error != nil {

					return res.Error
				}

				for _, val := range periods {

					fund := database.Funds{}
					res := tx.Where("id = ?", val.FundId).First(&fund)
					if res.Error != nil {

						return res.Error
					}

					//期数
					parts, _ := strconv.Atoi(strings.Split(val.PeriodsNumber, "#")[0])

					//找出该产品认购的人进行发放利息
					var userSub []database.SubFund

					res = tx.Where("fund_id = ? and is_return = 0 and status = ?", fund.Id, 1).Find(&userSub)

					if res.Error != nil {

						return res.Error
					}

					allInterest := big.NewFloat(0)
					for _, v := range userSub {

						//利息 = 认购金额 * (派息百分比/100)
						periodsShare := new(big.Float).Mul(new(big.Float).SetFloat64(v.ShareAmount), new(big.Float).Quo(new(big.Float).SetFloat64(fund.DividendPercentage), big.NewFloat(100)))

						interest, _ := periodsShare.Float64()

						interestModel := database.InterestFunds{}
						interestModel.FundId = fund.Id
						interestModel.UserId = v.UserId
						interestModel.Interest = interest
						interestModel.CreatedAt = time.Now()
						interestModel.SubId = v.Id
						interestModel.PeriodsId = val.Id
						res = tx.Create(&interestModel)

						if res.Error != nil {

							return res.Error
						}

						allInterest.Add(allInterest, periodsShare)

						changeAccounts := database.NewChangeAccount(tx)
						account, err := changeAccounts.GetAccount(fund.CurrencyId, v.UserId)

						if err != nil {

							return err
						}
						//派发利息
						err = account.ChangeBalance(database.SubInterest, interest)
						if err != nil {

							return err
						}

						//最后一期需要返还本金
						if parts == fund.LockDividendCount {

							err = account.ChangeLockBalance(database.SubPrincipal, -v.ShareAmount)
							if err != nil {

								return err
							}

							err = account.ChangeBalance(database.SubPrincipal, v.ShareAmount)
							if err != nil {

								return err
							}

							res = tx.Model(database.SubFund{}).Where("id = ?", v.Id).Updates(map[string]interface{}{
								"status":    3,
								"is_return": 1,
							})
							if res.Error != nil {

								return res.Error
							}

							res = tx.Model(database.Funds{}).Where("id = ?", fund.Id).Updates(map[string]interface{}{
								"status": 4, //已结束
							})

							if res.Error != nil {

								return res.Error
							}
						}

					}

					res = tx.Model(database.FundsPeriods{}).Where("id = ?", val.Id).Updates(map[string]interface{}{
						"status":         2,
						"grant_interest": allInterest.String(),
						"grant_time":     time.Now(),
					})

					if res.Error != nil {

						return res.Error
					}

				}

				return nil
			})

			if err != nil {

				break
			}

		}
	}
}
