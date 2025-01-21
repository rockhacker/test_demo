package apiws

type QuoteData struct {
	Id      int64
	Close   float64
	Open    float64
	High    float64
	Low     float64
	Volume  float64
	Amount  float64
	Change  float64
	Period  string
	Code    string
	ForexId int
	Time    int64
}
