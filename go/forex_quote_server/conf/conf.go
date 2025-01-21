package conf

import (
	log "github.com/sirupsen/logrus"
	"github.com/spf13/viper"
)

var Config *viper.Viper

func Init() {

	Config = viper.New()
	Config.AddConfigPath("./")      // 文件所在目录
	Config.AddConfigPath("./conf/") // 文件所在目录
	Config.SetConfigName("config")  // 文件名
	Config.SetConfigType("ini")     // 文件类型

	if err := Config.ReadInConfig(); err != nil {
		if _, ok := err.(viper.ConfigFileNotFoundError); ok {
			log.Fatalln("找不到配置文件")
		} else {
			log.Fatalln("读取配置文件失败,检查配置文件是否错误")
		}
	}

	//host := config.GetString("redis.host") // 读取配置
	//fmt.Println("viper load ini: ", host)
}
