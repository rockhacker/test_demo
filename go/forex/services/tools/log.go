package tools

import (
	"forex/conf"
	log "github.com/sirupsen/logrus"
	"os"
)

func LogInit() {
	log.SetFormatter(&log.TextFormatter{
		//DisableColors: true,
		FullTimestamp: true,
		PadLevelText:  true,
	})
	//log.SetFormatter(&log.JSONFormatter{})
	log.SetOutput(os.Stdout)

	if conf.Config.GetBool("basic.debug_mode") {

		log.SetLevel(log.DebugLevel)
	} else {

		log.SetLevel(log.WarnLevel)
	}

	log.SetReportCaller(conf.Config.GetBool("basic.debug_file_location"))
}
