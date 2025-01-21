<?php
echo "跳转到这个页面代表流程正常";
$request = $_REQUEST;
file_put_contents("./logs/" . date("Y-m-d") . ".log",json_encode($request),FILE_APPEND);