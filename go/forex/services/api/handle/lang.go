package handle

import (
	"encoding/json"
	ginI18n "github.com/gin-contrib/i18n"
	"github.com/gin-gonic/gin"
	"golang.org/x/text/language"
)

func ApiLang() gin.HandlerFunc {
	return ginI18n.Localize(
		ginI18n.WithBundle(&ginI18n.BundleCfg{
			RootPath: "./lang/api",
			AcceptLanguage: []language.Tag{
				language.Chinese,
				language.English,
				language.Thai,
				language.Vietnamese,
				language.French,
				language.German,
				language.Spanish,
				language.Korean,
				language.Japanese,
				language.Italian,
				language.TraditionalChinese,
				language.Arabic,
			},
			DefaultLanguage:  language.English,
			FormatBundleFile: "json",
			UnmarshalFunc:    json.Unmarshal,
		}),
		ginI18n.WithGetLngHandle(
			func(context *gin.Context, defaultLng string) string {
				lng := context.GetHeader("lang")
				if lng == "" {
					return defaultLng
				}

				//针对不同语言矫正
				switch lng {
				case "vn": //越南语
					lng = "vi"
					break
				case "spa": //西班牙语
					lng = "es"
					break
				case "kr": //韩语
					lng = "ko"
					break
				case "jp": //日语
					lng = "ja"
					break
				case "hk": //繁体
					lng = "zh-Hant"
					break
				}

				return lng
			},
		),
	)
}
