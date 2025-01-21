<?php


namespace App\Http\Controllers\Admin;

use App\BlockChain\BlockChain;
use App\Console\Commands\IsoLever\Worker;
use App\Exceptions\ThrowException;
use App\Logic\Market;
use App\Models\Currency\CurrencyMatch;
use App\Models\Currency\CurrencyQuotation;
use App\Models\Feedback\Feedback;
use App\Models\Iso\IsoLever;
use App\Models\Lever\LeverTransaction;
use App\Models\User\User;
use Illuminate\Http\Request;

class IsoLeverController extends Controller
{
    public function index()
    {
        $matches = CurrencyMatch::where('open_iso', CurrencyMatch::ON)->get();
        return view('admin.isoLever.index', [
            'matches' => $matches
        ]);
    }

    public function list(Request $request)
    {
        $limit      = $request->input("limit", 10);
        $match_id   = $request->input('match_id', 0);
        $uid        = $request->input("uid", '');
        $mobile     = $request->input("mobile", '');
        $email      = $request->input("email", '');
        $status     = $request->input("status", -1);
        $type       = $request->input("type", 0);
        $order_list = IsoLever::when($match_id, function ($query, $match_id) {
            $query->where('currency_match_id', $match_id);
        })->when($uid != '', function ($query) use ($uid) {
            $query->whereHas('user', function ($query) use ($uid) {
                $query->where('uid', $uid);
            });
        })->when($email, function ($query, $email) {
            $query->whereHas('user', function ($query) use ($email) {
                $query->where('email', $email);
            });
        })->when($mobile, function ($query, $mobile) {
            $query->whereHas('user', function ($query) use ($mobile) {
                $query->where('mobile', $mobile);
            });
        })->when($type > 0, function ($query) use ($type) {
            $query->where('type', $type);
        })->when($status <> -1, function ($query) use ($status) {
            $query->where('status', $status);
        })->orderBy('id', 'desc')->paginate($limit);

        $order_list->each(function ($order) {
            $order->append('uid', 'symbol', 'now_profits');
        });

        return $this->layuiPageData($order_list);
    }

    /**
     * 平仓
     * @return \Illuminate\Http\JsonResponse
     * @throws ThrowException
     */
    public function close()
    {
        return transaction(function () {
            $id    = request('id', 0);
            $iso   = IsoLever::find($id);
            $close = CurrencyQuotation::where('currency_match_id', $iso->currency_match_id)->value('close');

            $res = Worker::http(Worker::METHOD_CLOSE, [
                'id'          => $id,
                'type'        => IsoLever::CLOSE_ADMIN,
                'close_price' => $close,
            ]);
            if (!$res['code']) {
                throw new \Exception($res['msg']);
            }
            return $this->success('平仓成功');
        });
    }

    /**
     * 插针
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ThrowException
     */
    public function market(Request $request)
    {
        $trade_id     = $request->input('id', 0);
        $update_price = $request->input('update_price', 0);
        if ($trade_id <= 0 || $update_price <= 0) {
            throw new ThrowException('参数不合法');
        }
        $trade = IsoLever::where('status', IsoLever::STATUS_TX)->find($trade_id);
        if (!$trade) {
            throw new ThrowException('交易不存在或已平仓');
        }
        $match = CurrencyMatch::find($trade->currency_match_id);
        Market::handleKline($match->id, $match->symbol, $update_price, 0, $match->market_from);
        return $this->success('向系统发送价格成功');
    }

    /**
     * 撤单
     * @return \Illuminate\Http\JsonResponse
     * @throws ThrowException
     */
    public function cancel()
    {
        return transaction(function () {
            $id  = request('id', 0);
            $res = Worker::http(Worker::METHOD_CANCEL, [
                'id' => $id,
            ]);
            if (!$res['code']) {
                throw new \Exception($res['msg']);
            }
            return $this->success('撤单成功');
        });
    }
}
