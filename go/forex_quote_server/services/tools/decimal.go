package tools

import (
	"fmt"
	"strconv"
)

//Decimal format can exp %.nf or %.n+1f,n is uint number
func Decimal(num float64, format string) float64 {
	num, err := strconv.ParseFloat(fmt.Sprintf(format, num), 64)

	if err != nil {

		num = 0
	}

	return num
}
