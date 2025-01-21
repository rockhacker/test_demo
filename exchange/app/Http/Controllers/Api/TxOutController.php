<?php


namespace App\Http\Controllers\Api;


use App\Exceptions\ThrowException;
use App\Jobs\MatchEngine;
use App\Models\Account\AccountLog;
use App\Models\Currency\CurrencyMatch;
use App\Models\Project\Project;
use App\Models\Setting\Setting;
use App\Models\Tx\TxIn;
use App\Models\Tx\TxOut;
use App\Models\User\User;
use Illuminate\Support\Facades\Redis as RedisFacade;

class TxOutController extends Controller
{

    /**发布卖出
     *
     * @throws ThrowException
     */
    public function add()
    {
        $redis = RedisFacade::connection('default');

        $exist = $redis->get(User::getUserId()."_"."tx");

        if($exist){

            return $this->error(__('api.操作太频繁'));
        }
        return transaction(function ()  use($redis){
            $currency_match_id = request('currency_match_id', 0);
            $price = request('price', 0);
            $number = request('number', 0);

            $price = parse_price($price,'',9);
            $number = parse_number($price, $number,'',9);

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

            $out = TxOut::generateTx(User::getUserId(), $currencyMatch, $number, $price);
            $redis->setex(User::getUserId()."_"."tx",2,1);
            return $this->success(__('api.发布成功'), $out);
        });
    }

    /**取消买入订单
     *
     * @throws \Exception
     */
    public function cancel()
    {
        $id = request('id', 0);
        $out = TxOut::find($id);
        if (!$out) {
            return $this->error(__('api.找不到这个单子'));
        }
        if (Setting::getValueByKey("match_auto", "0") == "1") {

            $out->cancel();
        } else {

            $order = TxOut::lockForUpdate()->find($id);
            $order->returnBalance(AccountLog::TX_CANCEL)->delete();
        }
        return $this->success(__('api.撤单请求已发送'));
    }

    /**订单详情
     *
     */
    public function detail()
    {
        $id = request('id', 0);
        $out = TxOut::find($id);
        if (!$out) {
            return $this->error(__('api.找不到这个单子'));
        }
        return $this->success(__('api.请求成功'), $out);
    }

    /**订单列表
     *
     */
    public function list()
    {
        $limit = request('limit', 10);
        $currency_match_id = request('currency_match_id', 0);
        $outs = TxOut::with('currencyMatch')->where('user_id', User::getUserId())
            ->when($currency_match_id, function ($query, $currency_match_id) {
                $query->where('currency_match_id', $currency_match_id);
            })->orderBy('id', 'DESC')->paginate($limit);
        return $this->success(__('api.请求成功'), $outs);
    }
}
