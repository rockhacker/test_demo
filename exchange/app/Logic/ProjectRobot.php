<?php


namespace App\Logic;

use App\BlockChain\BlockChain;
use App\Console\Commands\Robot\Worker;
use App\Entity\Market\Depth;
use App\Entity\Market\DepthTx;
use App\Entity\TxCompleteEntity;
use App\Entity\TxOrder;
use App\Jobs\ClearTxOrder;
use App\Jobs\MatchEngine;
use App\Jobs\PushMarket;
use App\Models\Currency\CurrencyMatch;
use App\Models\Project\ProjectRobotPeriods;
use App\Models\Project\ProjectRobots;
use App\Models\Tx\Robot as RobotModel;
use App\Models\Tx\TxComplete;
use App\Models\User\User;
use Faker\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

class ProjectRobot
{

    protected $day_micro = 86400;

    /***当前推送价格
     *
     * @var float
     */
    protected $price;

    /**推送数量
     *
     * @var float
     */
    protected $amount;

    /**
     * @var CurrencyMatch
     */
    protected $currencyMatch;

    /**获取的火币基准价
     *
     * @var float
     */
    protected $huobi_first_price = 0;

    /**机器人价格
     *
     * @var float
     */
    protected $robot_price = 0;

    /**最后一次推送的价格
     *
     * @var float
     */
    protected $last_push_price = 0;

    protected $since_3s_price = 0;

    /**
     * @var Worker
     */
    protected $command;

    /**
     * @var ProjectRobots
     */
    protected $robot;

    protected $process_id;

    protected $updated_at;

    /**
     * @var int 今日开盘价格
     */
    protected $day_open_price = 0;

    /**
     * @var int 每小时收盘价格
     */
    protected $day_close_price = [];

    protected $decimal;

    protected $last_hour_price = 0;

    /**
     * @var array 每小时的涨幅
     */
    protected $change = [];

    public function __construct($process_id, $command)
    {
        $this->command = $command;

        $this->process_id = $process_id;
        $this->command->info('项目机器人运行开始:pid:' . $process_id);
    }

    public function init()
    {
        $this->robot = ProjectRobots::where('process_id', $this->process_id)->first();
        if (!$this->robot) {
            $this->command->info('项目机器人不存在pid:' . $this->process_id);
            return false;
        }

        $this->updated_at = $this->robot->updated_at;
        $this->command->info('项目机器人初始化完成:pid:' . $this->process_id);
        return true;
    }

    public function run()
    {
        try {

            if (!$this->init()) {
                return;
            }
            $this->decimal = 8;
            $this->currencyMatch = $this->robot->currencyMatch;
            $period = date("Ymd") . $this->robot->id;
            $model = ProjectRobotPeriods::where("period", $period)->first();

            if ($this->robot->current_price <= 0) {

                $price = $this->robot->open_price;

            } else {

                $price = $this->robot->current_price;
            }

            if (empty($model)) {

                $change = [];
                $day_close_price = [];
                $sum = 0;
                //生成每小时涨幅
                for ($i = 0; $i < 24; $i++) {

                    $change[$i] = mt_rand($this->robot->min_default_change * 10000, $this->robot->max_default_change * 10000) / 10000;
                    $sum += $change[$i];
                    $day_close_price[$i] = 0;
                }

                ProjectRobotPeriods::Create([
                    'day_open_price' => $price,
                    'period' => $period,
                    'robot_id' => $this->robot->id,
                    'change' => json_encode($change),
                    'day_close_price' => json_encode($day_close_price),
                    'all_change' => $sum,
                ]);
                $this->day_open_price = $price;

                //默认每小时涨幅
                $this->change = $change;
                $this->day_close_price = $day_close_price;
                $this->last_hour_price = $price;

            } else {
                if ($model->day_open_price) {
                    $this->day_open_price = $model->day_open_price;
                    $this->last_hour_price = $this->robot->last_hour_price;
                    $this->change = json_decode($model->change, true);
                    $this->day_close_price = json_decode($model->day_close_price, true);
                } else {
                    ProjectRobotPeriods::where("id", $model->id)->update([
                        'day_open_price' => $price,
                    ]);
                    return;
                }

            }

            $this->generateMarket();

        } catch (\Throwable $t) {
            dump($t->getMessage());
            dump($t->getFile());
            dump($t->getLine());
        }

    }

    /**直接生成行情
     *
     * @throws \Exception
     * @throws InvalidArgumentException
     */
    public function generateMarket()
    {

        $nowH = intval(date("H"));
        $float = 0;
//
//        $float = $float + $nowH;

        $faker = Factory::create();

        //每小时涨幅
        if(empty($this->change[$nowH])){

            $change = 0;
        }else{

            $change = $this->change[$nowH];
        }
        //涨跌权重，负数为跌
        $UDWeights = 0;

        if ($this->robot->current_price <= 0) {

            //当前价格
            $current_price = $this->robot->day_open_price;
        } else {

            $current_price = $this->robot->current_price;
        }


        //如果三分钟内幅过大，则调整
        $since_3s_price = cache::get("since_3s_price_" . $this->robot->id);
        if ($since_3s_price) {

            //5分钟前涨幅
            $since_current_change = abs(round((($current_price - $since_3s_price) / $since_3s_price), 5));

            if ($current_price < $this->since_3s_price) {

                //如果当前价小于5分钟前的价格，则转换为负数
                $since_current_change *= -1;
            }
            //k线需回调
            $backChange = 0.014;
            if ($since_current_change >= $backChange) {

                if ($change > 0) {

                    $UDWeights = $UDWeights - 15;
                } else {

                    $UDWeights = $UDWeights + 15;
                }
            }
        }
        //当前涨幅
//        $current_change = abs(round((($this->day_open_price - $current_price) / $this->day_open_price), 5));
        if ($this->last_hour_price == 0) {

            $this->last_hour_price = $current_price;
        }
        $current_change = abs(round((($this->last_hour_price - $current_price) / $this->last_hour_price), 6));


        if ($current_price < $this->last_hour_price) {

            //如果当前价小于开盘价，则转换为负数
            $current_change *= -1;
        }

        echo "当前涨幅：$current_change" . PHP_EOL;
        echo "设定涨幅：$change" . PHP_EOL;
        var_dump($this->last_hour_price, "---", $current_price);
        echo PHP_EOL;
        if ($current_price > 0) {

//            $autoChange = abs($change * $float) <= 1 ? 1 : abs($change * $float);
//            $autoChange = abs($float*0.4) <= 1 ? 1 : abs($float*0.4);
            $autoChange = $change * 900;
            $fen = intval(date("i") / 20);
            //设置涨幅为涨时
            if ($change > 0) {
                //已经达到目标
                if ($current_change >= $change) {
                    echo "已经达到目标:涨" . PHP_EOL;
                    //如果已经到达涨幅目标，需要调整涨幅
                    //在最后时刻再做调整
//                    if($nowH>20 && mt_rand(1,2) === 2){

                    $UDWeights += -round($autoChange, 4);
                    if ($UDWeights < 0) $UDWeights = -5;
//                        $UDWeights = $UDWeights - mt_rand(1, $autoChange);
//                    }

                } else {
                    echo "未达到目标:涨" . PHP_EOL;
                    if (abs($autoChange) > 1) {
                        $UDWeights = $UDWeights + mt_rand(1, abs($autoChange)) + $fen;
                    } else {

                        $UDWeights = $UDWeights + 2;
                    }

                }
            } else {
                //设置涨幅为跌时

                //已经达到目标
                if ($current_change <= $change) {
                    echo "已经达到目标:跌" . PHP_EOL;

                    //如果已经到达涨幅目标，需要调整涨幅
                    //在最后时刻再做调整
//                    if($nowH>20 && mt_rand(1,2) === 2){

                    $UDWeights += +round($autoChange, 4);
                    if ($UDWeights < 0) $UDWeights = 5 + $fen;

//                        $UDWeights = $UDWeights + mt_rand(1, $autoChange);
//                    }

                } else {
                    echo "未达到目标:跌" . PHP_EOL;
                    if (abs($autoChange) > 1) {

                        $UDWeights = $UDWeights - mt_rand(1, abs($autoChange)) - $fen;
                    } else {

                        $UDWeights = $UDWeights - 2 - $fen;;
                    }
                }

            }

            var_dump($UDWeights, $change);
            var_dump("-0-----------------------");
            $filed_change = mt_rand(1, 2) * 0.00005;
            $target_price = $current_price * $filed_change;
            $bili = 100 + $UDWeights;
            if (mt_rand(0, $bili) >= 50) {
                $max_price = $current_price + $target_price;
            } else {
                $max_price = $current_price - $target_price;
            }
            echo("target price:$target_price" . PHP_EOL);

            if ($max_price <= $current_price) {

                $price = $faker->randomFloat($this->decimal, $max_price, $current_price);
            } else {
                $price = $faker->randomFloat($this->decimal, $current_price, $max_price);
            }

            echo("currency price:$current_price" . PHP_EOL);
            echo("price:$price" . PHP_EOL);
        } else {

            $price = $faker->randomFloat($this->decimal, $current_price, $current_price);
        }

        //最后矫正行情
        //如果设置的涨幅
        //不需要矫正可以注释不影响行情
//        if ($change > 0) {
//
//            //当前价不能低于开盘价
//            if ($price <= $this->day_open_price) {
//
//                $price = $this->day_open_price;
//            }
//
//
//        } else {
//
//            //当前价不能高于开盘价
//            if ($price >= $this->day_open_price) {
//
//                $price = $this->day_open_price;
//            }
//
//        }
//        if ($change > 0) {
//
//            //当前价不能低于开盘价百分之5
//            if ($price <= $this->day_open_price*0.95) {
//
//                $price = $this->day_open_price*0.95;
//            }
//
//
//        } else {
//
//            //当前价不能高于开盘价百分之5
//            if ($price >= $this->day_open_price*0.95) {
//
//                $price = $this->day_open_price*0.95;
//            }
//
//        }

        if(date("i") == 59 && date("s") >= 57){

            //强行矫正到设定的收盘价，不需要可以不用这段代码
            if (floatval($this->day_close_price[$nowH]) != 0) {

                $price = $this->day_close_price[$nowH];
            }
        }

        if ($this->robot->push_price > 0) {

            $price = $this->robot->push_price;
        }


        $amount = mt_rand(1001, 10000);

        $way = mt_rand(0, 1) ? TxComplete::OUT : TxComplete::IN;
        $completes = collect();
        $currency_match_id = $this->robot->currency_match_id;
        $amount = $faker->randomFloat($this->decimal, 1000, $amount);
        $txCompleteEntity = new TxCompleteEntity();
        $txCompleteEntity->in_user_id = $this->currencyMatch->match_user_id;
        $txCompleteEntity->out_user_id = $this->currencyMatch->match_user_id;
        $txCompleteEntity->price = $price;
        $txCompleteEntity->amount =  mt_rand(1,10) == 1?$amount : $amount/10;;
        $txCompleteEntity->way = $way;
        $txCompleteEntity->currency_match_id = $currency_match_id;
        $completes->prepend($txCompleteEntity);
        $depth_buys = $this->virtualDepthBuys($this->currencyMatch->symbol, $price);
        $depth_sells = $this->virtualDepthSells($this->currencyMatch->symbol, $price);
        $depth = new Depth($this->currencyMatch->symbol, $depth_buys, $depth_sells, $currency_match_id);

        //记录一个5分钟前的价格
        if (time() % 300 == 0) {
            cache::set("since_3s_price_" . $this->robot->id, $price, 200);
        }
        $update_data = [
            "current_price" => $price,
            "push_price" => 0,
        ];
        //最后一分钟记录一个价格
        if (date("i") == 59) {

            $update_data['last_hour_price'] = $price;
        } else {

            //如果等于0或者没有，也需要记录
            if (!$this->last_hour_price) {

                $update_data['last_hour_price'] = $price;
            }
        }


        $this->robot->update($update_data);
        PushMarket::dispatch(
            $currency_match_id, $this->currencyMatch->symbol, $price, $completes->take(30), $depth, CurrencyMatch::ROBOT
        )->onQueue('pushMarket')->onConnection('sync');

    }


    /**虚拟买入深度
     *
     * @param     $symbol
     * @param     $price
     * @param int $limit
     *
     * @return Collection
     */
    public function virtualDepthBuys($symbol, $price, $limit = 10): Collection
    {
        $min_price = 0.000001;
        $faker = Factory::create();

        $buys = collect();
        for ($i = 0; $i < $limit; $i++) {
            $amount = round($faker->randomFloat(9 - $this->decimal, 200, 2000), 8);
            $buy_price = bc($price - ($i + 1) * $min_price, '+', 0, $this->decimal);

            $depthSell = new DepthTx($amount, $buy_price);
            $buys->push($depthSell);
        }
        return $buys;
    }

    /**虚拟卖出深度
     *
     * @param     $symbol
     * @param     $price
     * @param int $limit
     *
     * @return Collection
     */
    public function virtualDepthSells($symbol, $price, $limit = 10): Collection
    {
        $min_price = 0.000001;

        $faker = Factory::create();

        $sells = collect();
        for ($i = 0; $i < $limit; $i++) {
            $amount = round($faker->randomFloat(9 - $this->decimal, 200, 1000), 8);
            $out_price = bc($price + ($i + 1) * $min_price, '+', 0, $this->decimal);

            $depthSell = new DepthTx($amount, $out_price);
            $sells->push($depthSell);
        }
        return $sells;
    }

    /**
     * 优化算法
     * @return int
     */
    public function nowMicro(): int
    {
        $date = strtotime(date("Y-m-d 23:59:59"));

        $now_date = strtotime(date("Y-m-d H:i:s"));

        return $date - $now_date;
    }

}
