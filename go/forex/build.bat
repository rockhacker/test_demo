set CGO_ENABLED=0
set GOOS=linux
set GOARCH=amd64
set GO11MODULE=off
go env -w GOPROXY=https://goproxy.cn,direct
go build