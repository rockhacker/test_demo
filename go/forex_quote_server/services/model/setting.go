package model

import "strconv"

type Settings struct {
	Id    int `gorm:"primaryKey;unique"`
	Key   string
	Value string
}

func (s *Settings) ForexBurstHazardRate() float64 {

	DB.Where("`key` = ?", "lever_burst_hazard_rate").First(&s)

	if s.Id != 0 {

		r, err := strconv.ParseFloat(s.Value, 64)

		if err == nil {

			return 0
		}
		return r
	} else {

		return 0
	}
}
