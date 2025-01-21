<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ThrowException;
use App\Jobs\MicroAddOrder;
use App\Models\Project\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use App\Models\Account\{Account, AccountType, MicroAccount};
use App\Models\Currency\{Currency, CurrencyMatch};
use App\Models\Micro\{MicroSecond, MicroOrder};
use App\Models\User\User;
use App\Logic\MicroTrade;

class MicroOrderController extends Controller
{

    /**
     * 取允许支付的币种
     *
     * @return JsonResponse
     */
    public function getPayableCurrencies(): JsonResponse
    {
        $currencies = Currency::with(['microNumbers' => function ($query) {
            $query->orderBy('number');
        }])->get()->filter(function ($currency, $key) {
            return $currency->micro_account_display;
        })->values();

        $currencies = $currencies->transform(function ($currency, $key) {
            // 追加上用户的钱包
            try {
                $account = Account::getAccountByType(AccountType::MICRO_ACCOUNT_ID, $currency->id);
                $currency->setAttribute('micro_account', $account ?? null);
                return $currency;
            } catch (ThrowException $e) {

            }
        })->filter(function ($currency) {
            return !is_null($currency);
        })->values();
        return $this->success('', $currencies);
    }

    /**
     * 取到期时间
     */
    public function getSeconds()
    {
        $seconds = MicroSecond::where('status', MicroSecond::STATUS_ON)
            ->orderBy('seconds')->get();
        return $this->success('', $seconds);
    }

    /**
     * 下单
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function submit(Request $request): JsonResponse
    {
        try {
            $user_id = User::getUserId();
            $type = $request->input('type', 0);
            $match_id = $request->input('match_id', 0);
            $currency_id = $request->input('currency_id', 0);
            $seconds = $request->input('seconds', 0);
            $number = $request->input('number', 0);
            $validator = Validator::make($request->all(), [
                'match_id' => 'required|integer|min:1',
                'currency_id' => 'required|integer|min:1',
                'type' => 'required|integer|in:1,2',
                'seconds' => 'required|integer|min:1',
                'number' => 'required|min:0',
            ], [], [
                'match_id' => '交易对',
                'currency_id' => '支付币种',
                'type' => '下单类型',
                'seconds' => '到期时间',
                'number' => 'Member',
            ]);
            //进行基本验证
            throw_if($validator->fails(), new \Exception($validator->errors()->first()));
            throw_if($validator->fails(), new \Exception($validator->errors()->first()));

            if(Redis::get('micro_add_queue_lock_' . $user_id)){
                throw new \Exception(__('api.操作太频繁'));
            }

            $currency = Currency::find($currency_id);
            throw_unless($currency->micro_account_display, new \Exception(__('api.当前币种账户不支持此交易')));
            $currencyMatch = CurrencyMatch::find($match_id);
            $isStart = Project::where("end_time",'>=',date("Y-m-d H:i:s"))
                ->where("currency_id",$currencyMatch->base_currency_id)
                ->exists();
            if ($isStart) {
                throw new ThrowException(__('api.该币种暂时无法交易,因为该币种处于认购期'));
            }
            throw_unless($currencyMatch->open_microtrade, new \Exception(__('api.当前交易对不支持此交易')));
//            if (bc(100, '>', $number)) {
//                throw new \Exception(__('api.最小下单数量不能小于:100'));
//            }
//            if ($number <= 0) {
//                throw new \Exception("Member cannot be less than 0");
//            }
            $user = User::find($user_id);
            throw_unless($user, new \Exception('用户无效'));
            //检测交易对是否存在
            $currency_match = CurrencyMatch::findOrFail($match_id);
            throw_unless($currency_match, new \Exception('交易对不存在'));
            throw_unless($currency_match->open_microtrade, new \Exception('交易未开启'));
            $currency = Currency::findOrFail($currency_id);
            throw_unless($currency->micro_account_display, new \Exception('币种不允许被交易'));
            //检测秒数是否在合法范围内
            $check_seconds = MicroSecond::where('seconds', $seconds)->first();
            throw_unless($check_seconds, new \Exception('到期时间不允许'));

            $account = MicroAccount::getBalance($currency_id, $user_id);
            if($account < $number){
                throw new ThrowException(__('model.余额不足'));
            }
            $close = $currencyMatch->getLastPrice();
            $price = $close;
            $order_data = [
                'user_id' => $user_id,
                'type' => $type,
                'match_id' => $match_id,
                'currency_id' => $currency_id,
                'seconds' => $seconds,
                'price' => $price,
                'number' => $number,
            ];
//            Redis::set('micro_add_queue_lock_' . $user_id, $user_id,120);
//            Redis::rPush('micro_add_queue',json_encode($order_data));
//            MicroAddOrder::dispatch($order_data)->onQueue('microAddOrder');
            $order = MicroTrade::addOrder($order_data);
            return $this->success(__('api.下单成功'), $order_data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    public function lists(Request $request)
    {
        try {
            $user_id = User::getUserId();
            $limit = $request->input('limit', 10);
            $status = $request->input('status', -1);
            $match_id = $request->input('match_id', -1);
            $currency_id = $request->input('currency_id', -1);
            $lists = MicroOrder::where('user_id', $user_id)
                ->when($status <> -1, function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->when($match_id <> -1, function ($query) use ($match_id) {
                    $query->where('match_id', $match_id);
                })
                ->when($currency_id <> -1, function ($query) use ($currency_id) {
                    $query->where('currency_id', $currency_id);
                })
                ->orderBy('id', 'desc')
                ->paginate($limit);
            $lists->each(function ($item, $key) {
                return $item->append('remain_milli_seconds');
            });
            /*
            $results = $lists->getCollection();
            $results->transform(function ($item, $key) {
                return $item->append('remain_milli_seconds');
            });
            $lists->setCollection($results);
            */
            return $this->success('', $lists);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * 获得该币种交易中的交割订单
     * @param $user_id
     * @param $currency_id
     * @return int
     */
    protected function getExistingOrderNumber($user_id, $currency_id): int
    {
        $count = MicroOrder::where('user_id', $user_id)
            ->where('status', MicroOrder::STATUS_OPENED)
            ->where('currency_id', $currency_id)
            ->count();
        return $count;
    }
}
