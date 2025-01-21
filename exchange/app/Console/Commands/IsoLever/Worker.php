<?php

namespace App\Console\Commands\IsoLever;

use App\Console\Commands\Socket\InitArgument;
use App\Logic\Robot;
use App\Models\Currency\CurrencyQuotation;
use App\Models\Iso\IsoLever;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Workerman\Connection\TcpConnection;
use Workerman\Lib\Timer;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;

class Worker extends Command
{
    const METHOD_ORDER        = 'newOrder';   //新订单
    const METHOD_CANCEL       = 'cancel';     //撤单
    const METHOD_CLOSE        = 'close';      //平仓
    const METHOD_SET_STOP     = 'setStop';    //设置止盈止损
    const METHOD_UPDATE_ORDER = 'updateOrder';//更新订单
    const METHOD_ON_MARKET    = 'onMarket';   //新行情

    use InitArgument;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'isoLever:worker {worker_command} {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var Collection
     */
    protected $orders;

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

        $host         = config('app.ios_lever_host', 'http://127.0.0.1:4000');
        $this->worker = new \Workerman\Worker($host);

        $this->worker->name = 'isoLever:worker';

        $this->worker->onWorkerStart = [$this, 'onWorkerStart'];
        $this->worker->onMessage     = [$this, 'onMessage'];

        //设置pid路径
        $path = storage_path('isoLever/');
        file_exists($path) || @mkdir($path);
        \Workerman\Worker::$pidFile = $path . 'worker.pid';
        \Workerman\Worker::runAll();
    }

    public function onWorkerStart()
    {
        try {
            $this->loadOrders();
        } catch (\Throwable $t) {
            print_info($t->getMessage());
            print_info($t->getFile());
            print_info($t->getLine());
        }
    }

    /**
     * @param TcpConnection $con
     * @param Request $request
     */
    public function onMessage($con, $request)
    {
        try {
            $method = $request->get('method');

            if (!method_exists($this, $method)) {
                $res = $this->errorResponse('找不到处理方法' . $method);
            } else {
                print_info("处理方法:{$method}");
                $res = $this->$method($request);
            }

        } catch (\Throwable $t) {

            print_info($t->getMessage());
            print_info($t->getFile());
            print_info($t->getLine());

            $res = $this->errorResponse($t->getMessage(), [
                'file' => $t->getFile(),
                'line' => $t->getLine(),
            ]);
        } finally {
            $this->returnResponse($con, $res);
        }

    }

    /**
     * @param Request $request
     */
    public function onMarket($request)
    {
        $currency_match_id = $request->get('currency_match_id');
        $close             = $request->get('close', 0);
        if ($close <= 0) {
            return;
        }

        $this->orders = $this->orders->transform(function ($order) use ($currency_match_id, $close) {

            /**@var $order IsoLever* */
            if ($order->currency_match_id != $currency_match_id) {
                return $order;
            }

            $is_active = $order->checkActive($close);
            if ($is_active) {
                print_info("激活id:{$order->id}");
                return $order;
            }

            //交易中才打印盈亏
            if ($order->status == IsoLever::STATUS_TX && config('app.debug')) {
//                $profit = $order->getProfit($close);
//                print_info("单子id:{$order->id},盈亏:{$profit}");
            }

            $is_boom = $order->checkBoom($close);
            if ($is_boom) {
                print_info("爆仓id:{$order->id}");
                return null;
            }

            $is_stop = $order->checkStop($close);
            if ($is_stop) {
                print_info("止盈止损id:{$order->id}");
                return null;
            }

            return $order;
        })->filter(function ($order) {
            return !is_null($order);
        });

        return $this->successResponse('发送价格成功');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function newOrder($request)
    {
        $id    = $request->get('id');
        $order = IsoLever::find($id);
        if (!$order) {
            return $this->errorResponse('找不到单子');
        }
        $this->orders->push($order);
        print_info("新订单ID:{$order->id}");
        return $this->successResponse('挂单成功');
    }
    /**
     * 撤单方法
     * @param $request
     * @return array
     * @throws \Exception
     */
    public function cancel($request)
    {
        $id = $request->get('id');
        /**@var $order IsoLever* */
        $order = $this->orders->where('id', $id)->first();
        if (!$order) {
            return $this->errorResponse('找不到单子');
        }
        $order->cancel();
        $this->removeOrderById($id);
        return $this->successResponse('撤单成功', [
            'id' => "撤单id:{$id}"
        ]);
    }

    /**
     * 平仓
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function close($request)
    {
        $id = $request->get('id');
        /**@var $order IsoLever* */
        $order = $this->orders->where('id', $id)->first();
        if (!$order) {
            return $this->errorResponse('找不到单子');
        }
        $order->close($request->get('type'), $request->get('close_price'));
        $this->removeOrderById($id);
        return $this->successResponse('平仓成功', [
            'id' => "平仓id:" . $request->get('id')
        ]);
    }

    /**根据id移除订单
     *
     * @param $id
     */
    public function removeOrderById($id)
    {
        $this->orders = $this->orders->filter(function ($order) use ($id) {
            /**@var $order IsoLever* */
            return $order->id != $id;
        });
    }

    /**重新把数据库中的某条记录同步到内存
     *
     * @param Request $request
     *
     * @return array
     */
    public function updateOrder($request)
    {
        $id = $request->get('id');
        /**@var $order IsoLever* */
        $order = $this->orders->where('id', $id)->first();
        if (!$order) {
            return $this->errorResponse('找不到这个单子');
        }
        $order->refresh();
        return $this->successResponse('单子更新成功');
    }

    /**载入订单
     *
     */
    public function loadOrders()
    {
        print_info('开始载入订单');
        $this->orders = collect();
        foreach (
            IsoLever::whereIn('status', [IsoLever::STATUS_TX, IsoLever::STATUS_WAIT])->cursor() as $order
        ) {
            $this->orders->push($order);
        }
        print_info('载入订单完成');
    }

    public function successResponse($msg, $data = [])
    {
        return [
            'code' => 1,
            'msg'  => $msg,
            'data' => $data,
        ];
    }

    public function errorResponse($msg, $data = [])
    {
        return [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
        ];
    }


    /**返回相应
     *
     * @param TcpConnection $con
     * @param array $arr_data
     */
    public function returnResponse($con, $arr_data)
    {
        $response = new Response(200, [
            'Content-Type' => 'application/json',
        ], json_encode($arr_data));

        $con->send($response);
    }

    /**
     * @param $data
     *
     * @return array|mixed
     * @throws \Exception
     */
    public static function http($method, $data = [])
    {
        $host           = config('app.ios_lever_host');
        $data['method'] = $method;
        try {
            return http($host, $data);
        } catch (GuzzleException $e) {
            if ($data['type'] == IsoLever::CLOSE_ADMIN) {
                throw new \Exception('worker进程服务异常:' . $e->getMessage());
            }
            throw new \Exception('worker进程服务异常');
        }
    }
}
