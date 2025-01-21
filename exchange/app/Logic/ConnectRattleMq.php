<?php


namespace App\Logic;


use Exception;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class ConnectRattleMq
{

    public static $quoteOperateConsume = "quoteoperateconsume";
    public static $quoteHandleConsume = "quotehandleconsume";
    public static $leverPushTradeConsume = "leverpushtradeconsume";
    public static $handleUserLeverConsume = "handleuserleverconsume";
    public static $leverCloseConsume = "levercloseconsume";

    public static $microUpdateQueueConsume = "microupdatequeueconsume";
    public static $microCloseConsume = "microcloseconsume";

    public static $robotWorkerConsume = "robotworkerconsume";

    /**
     * @return AMQPStreamConnection
     * @throws Exception
     */
    public static function conn(): AMQPStreamConnection
    {
        try {

            return new AMQPStreamConnection("192.168.0.1",5672,"admin","admin","/");

        }catch(Exception $exception){

            throw new Exception($exception->getMessage());
        }

    }

    public static function publish_send($quote_name ,$params)
    {
        try {
            $conn = self::conn();
            $channel = $conn->channel();
            $arguments = new AMQPTable();
            $arguments->set("x-message-ttl", 1000);
            $channel->queue_declare($quote_name, false, false, false, true, false, $arguments);
            $data = json_encode($params);

            $msg = new AMQPMessage($data ,[
                'deliver_mode'=>AMQPMessage::DELIVERY_MODE_NON_PERSISTENT,
                'expiration'=>1000
            ]);
            $channel->basic_publish($msg,"",$quote_name);
            $channel->close();
            $conn->close();

        } catch (Exception $e) {
        }



    }


}
