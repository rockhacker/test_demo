package tools

import "time"

func WeekFormatInt(w time.Weekday) int64 {
	switch w.String() {
	case "Monday":

		return 1
	case "Tuesday":

		return 2
	case "Wednesday":

		return 3

	case "Thursday":

		return 4

	case "Friday":

		return 5

	case "Saturday":

		return 6

	case "Sunday":

		return 0

	}
	return 0
}
