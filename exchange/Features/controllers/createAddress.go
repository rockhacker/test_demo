package controllers

import (
    "exchange_features/database"
    "log"
    "net/http"
    "os"
    "strconv"
    "time"
)

type CreateAddress struct{}

func (c CreateAddress) Check() {

	db := database.DB
    log.Println("已创建生成地址协程")
	for {

		var users []database.Users

		res := db.Where("is_create_address = ?", 0).Find(&users)

		if res.Error != nil {

			continue
		}

		for _, val := range users {

			c.run(val.Id)

			db.Model(database.Users{}).Where("id = ?", val.Id).Update("is_create_address", 1)

		}

		time.Sleep(2 * time.Second)
	}

}

func (c CreateAddress) run(id int) {

	resp, err := http.Get(os.Getenv("APP_URL")+"/api/apiCreateAddress?user_id="+strconv.Itoa(id))

	if err != nil {

		return
	}

	defer resp.Body.Close()

}
