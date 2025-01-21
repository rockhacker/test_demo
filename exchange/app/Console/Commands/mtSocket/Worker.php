<?php

namespace App\Console\Commands\mtSocket;

use App\Console\Commands\Socket\InitArgument;
use App\Logic\ProjectRobot;
use Illuminate\Console\Command;
use Workerman\Lib\Timer;
use Workerman\Connection\AsyncTcpConnection;

class Worker extends Command
{
    use InitArgument;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtSocket:worker {worker_command} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'mt行情机器人';

    /**
     * @var \Workerman\Worker
     */
    protected $worker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->initArgv();
//        $this->resetRobotPrice();

        $this->worker = new \Workerman\Worker();
        $this->worker->count = 1;//默认10个机器人进程
        $this->worker->name = 'mtSocket:worker';//默认10个机器人进程

        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];

        //设置pid路径
        $path = storage_path('mtSocket/');
        file_exists($path) || @mkdir($path);
        \Workerman\Worker::$pidFile = $path . 'worker.pid';
        \Workerman\Worker::runAll();
    }

    public function onWorkerStart()
    {
        try {

            $tcp_connect = 'tcp://154.85.51.28:9100';

            $con = new AsyncTcpConnection($tcp_connect);
            $data = [
                'post'=>[
                    'Cmd'=>'Market_Request',
//                    'Cmd'=>'ServerTime_get',
                    'ReceiveServer'=>"",
                    'ReceiveDatetype'=>0,
                    'MT4Server'=>[
                        'Addr'=>'154.85.51.28',
                        'Port'=>'443',
                        "ManagerUser"=> 1004,
                        "ManagerPassword"=> "abc123456",
                        "TimeOut"=>20
                    ],
                    'Request_Version'=>'2.0.0',
                ],
            ];
            $con->onConnect = function ($con) use($data){
                $Request_Serial = time() . rand(100, 999);
                $send_data = [];
                $this->conver_type($data['post'],$send_data);
                $params = [
                    'CstData' => [
                        'CstId' => 'CstId',
                        'CstPwd' => 'RXXpXOq9l+ZfNg+H4AM8ZLJDr8d8//CquPwe7dvv5e45tatllMJjC6O5Jj7jcwAu4FXsc6ufyhSgwx2OL31o1YVY4yPvpDhekhXS3G/TGR3wy0nOCLuEAaIwjF8GNBui1HVVTNIGoO1sAyqM0i85YYP1ukJLZRr8wjTed6CLJ58='
                    ],
                    'MT4Server' => $send_data['MT4Server'],
                    'Request_Serial' => $Request_Serial,
                    'Request_Time' => time(),
                    'Request_Version' => $send_data['Request_Version']
                ];
                unset($send_data['MT4Server']);
                $params['Request_Data'] = $send_data;

                $data = "W" . json_encode($params) . "QUIT\n";
                var_dump($data);
                $con->send($data);

            };

            $con->onMessage = function ($con, $data) {
                 echo $data . PHP_EOL;
                global $_MACHINE_CONN;
                $conn_id = $con->id;
                if(!isset( $_MACHINE_CONN[$conn_id]['msg_peer'])) {
                    $_MACHINE_CONN[$conn_id]['msg_peer'] = "";
                }

                $_MACHINE_CONN[$conn_id]['msg_peer'] = $_MACHINE_CONN[$conn_id]['msg_peer'] . $data;

                if (strpos($data, "and" ."\r") !== false) {
//            var_dump($_MACHINE_CONN[$conn_id]['msg_peer'] );

                    if(strpos("end",$_MACHINE_CONN[$conn_id]['msg_peer']) >= 0 ){
                        $str = substr($_MACHINE_CONN[$conn_id]['msg_peer'],0,-6);
                        // echo "66666". PHP_EOL;
                        var_dump(rtrim($str));
                        var_dump(json_decode(rtrim($str),true));

                    }else{

                        $d = rtrim($_MACHINE_CONN[$conn_id]['msg_peer'],"and");
                        $d = rtrim($d);
                        echo $d;

                    }

                    $con->close();
                    unset($_MACHINE_CONN[$conn_id]);
                }

            };
            $con->onError = function($connection, $err_code, $err_msg)
            {
                echo "$err_code, $err_msg";
            };
            $con->connect();
//            $robot = new ProjectRobot($this->worker->id, $this);
//            Timer::add(1, function () use ($robot) {
//                $robot->run();
//            });
        } catch (\Throwable $t) {
            $this->info($t->getMessage());
            $this->info($t->getFile());
            $this->info($t->getLine());
        }
    }


    private function conver_type ($send_data,&$res): array
    {

        if(is_array($send_data)  &&  $send_data){
            foreach($send_data as $k => $v){
                if($k == 'User'){
                    $res[$k] = $v;
                    continue;
                }
                if(is_numeric($v)){
                    $res[$k] = (int)$v;
                }else if(is_array($v)){

                    $this->conver_type($v,$res[$k]);
                }else{
                    $res[$k] = $v;
                }

            }

        }
        return [];
    }
}
