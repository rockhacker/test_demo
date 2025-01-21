<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;

$conn = new AMQPStreamConnection("127.0.0.1",5672,"guest","guest");

$channel = $conn->channel();

$channel->queue_declare("hello");

$callback = function ($msg){

    var_dump($msg->body);
};

$channel->basic_consume("hello","",false,false,false,false,$callback);


