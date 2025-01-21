<?php


namespace App\Http\Controllers\Api;


use App\Exceptions\ThrowException;
use App\Jobs\MatchEngine;
use App\Models\Account\AccountLog;
use App\Models\Currency\CurrencyMatch;
use App\Models\Project\Project;
use App\Models\Setting\Setting;
use App\Models\Tx\Tx;
use App\Models\Tx\TxIn;
use App\Models\User\User;
use Illuminate\Support\Facades\Redis as RedisFacade;
use Illuminate\Validation\Rules\In;

class TxInController extends Controller
{
    /**发布
     *
     */
    public function add()
    {

        $redis = RedisFacade::connection('default');

        $exist = $redis->get(User::getUserId()."_"."tx");

        if($exist){

            return $this->error(__('api.操作太频繁'));
        }
        return transaction(function () use($redis){

            $currency_match_id = request('currency_match_id', 0);
            $price = request('price', 0);
            $number = request('number', 0);

            $price = parse_price($price, '', 9);
            $number = parse_number($price, $number, '', 9);

            if (!is_numeric($price) || $price <= 0) {
                return $this->error(__('api.价格错误'));
            }
            if (!is_numeric($number) || $number <= 0) {
                return $this->error(__('api.数量错误'));
            }
//            if ($number > 10000000) {
//                throw new ThrowException(__('api.挂单量不能超过10000000'));
//            }

            $currencyMatch = CurrencyMatch::findOrFail($currency_match_id);

            $isStart = Project::where("end_time",'>=',date("Y-m-d H:i:s"))
                ->where("currency_id",$currencyMatch->base_currency_id)
                ->exists();
            if ($isStart) {

                throw new ThrowException(__('api.该币种暂时无法交易,因为该币种处于认购期'));
            }

            $in = TxIn::generateTx(User::getUserId(), $currencyMatch, $number, $price);
            $redis->setex(User::getUserId()."_"."tx",2,1);

            return $this->success(__('api.发布成功'), $in);
        });
    }

    /**取消订单
     *
     * @throws \Exception
     */
    public function cancel()
    {
        $id = request('id', 0);
        $in = TxIn::find($id);
        if (!$in) {
            return $this->error(__('api.找不到这个单子'));
        }
        if (Setting::getValueByKey("match_auto", "0") == "1") {

            $in->cancel();
        } else {

            $order = TxIn::lockForUpdate()->find($id);
            $order->returnBalance(AccountLog::TX_CANCEL)->delete();
        }
        return $this->success(__('api.撤单请求已发送'));
    }

    /**详情
     *
     */
    public function detail()
    {
        $id = request('id', 0);
        $in = TxIn::find($id);
        if (!$in) {
            return $this->error(__('api.找不到这个单子'));
        }
        return $this->success(__('api.请求成功'), $in);
    }

    /**列表
     *
     */
    public function list()
    {
        $limit = request('limit', 10);
        $currency_match_id = request('currency_match_id', 0);
        $ins = TxIn::with('currencyMatch')->where('user_id', User::getUserId())
            ->when($currency_match_id, function ($query, $currency_match_id) {
                $query->where('currency_match_id', $currency_match_id);
            })->orderBy('id', 'DESC')->paginate($limit);
        return $this->success(__('api.请求成功'), $ins);
    }
}
