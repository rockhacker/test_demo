<?php

namespace App\Http\Controllers\Api;


use App\Models\Account\Account;
use App\Models\Account\AccountType;
use App\Models\Currency\CurrencyMatch;
use App\Models\Iso\IsoLever;
use App\Models\Lever\LeverTransaction;
use App\Models\Setting\Setting;
use App\Models\User\User;

class IsoLeverController extends Controller
{
    /**
     * 返回逐仓交易页面需要的参数 手数倍数 手数限制  用户余额等
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function dealSetting()
    {
        $currency_match_id = request('currency_match_id');
        if (!$currency_match_id) {
            return $this->error(__("api.参数错误"));
        }
        $currency_match = CurrencyMatch::with(['currencyQuotation'])->findOrFail($currency_match_id);
        $lever_share_limit = [
            'min' => $currency_match->lever_min_share ?? 0,
            'max' => $currency_match->lever_max_share ?? 1,
        ];
        return $this->success("", [
            'quotation' => $currency_match->currencyQuotation,
            "lever_share_limit" => $lever_share_limit,
            'last_price' => $currency_match->getLastPrice(),
            "iso_lever_balance" => Account::getAccountByType(AccountType::ISOLATED_LEVER_ACCOUNT_ID, $currency_match->quote_currency_id)->balance,
            "multiple" => LeverTransaction::leverMultiple(),
        ]);
    }

    //原LevelController  dealAll方法             返回当前交易对 用户当前持仓
    public function currencyHold()
    {
        $currency_match_id = request("currency_match_id", 0);
        $limit = request("limit", 100);
        $currency_match = CurrencyMatch::where('id', $currency_match_id)->first();
        $user_id = User::getUserId();
        if (empty($currency_match)) {
            return $this->error(__("api.参数错误"));
        }
        $query = IsoLever::with('user')
            ->orderBy('id', 'desc')
            ->where("user_id", $user_id)
            ->where("status", IsoLever::STATUS_TX)
            ->where("currency_match_id", $currency_match->id)
            ->orderBy("id", "desc");
        $transactions = $query->paginate($limit);
        $profits_total = 0;
        foreach ($query->get() as $item) {
            switch ($item->type) {
                case 1:
                    $profits_total += bc($item->update_price, '-', $item->fact_price);
                    break;
                case 2:
                    $profits_total += bc($item->fact_price, '-', $item->update_price);
                    break;
                default:
                    $profits_total += 0;
            }
        }
        $account = Account::getAccountByType(AccountType::ISOLATED_LEVER_ACCOUNT_ID, $currency_match->quote_currency_id);
        $data = [
            'balance' => $account->balance,
            'transactions' => $transactions,
            'profits_total' => $profits_total,
        ];
        return $this->success('', $data);
    }

    /**
     * 返回当前交易对 交易记录
     * @return \Illuminate\Http\JsonResponse
     */
    public function myTransaction()
    {
        $user_id = User::getUserId();
        $currency_match_id = request("currency_match_id");
        $limit = request("limit", 100);
        $status = request("status", -1);

        $lever_transaction = IsoLever::when($currency_match_id, function ($query, $currency_match_id) {
            $query->where('currency_match_id', $currency_match_id);
        })->when($status, function ($query, $status) {
            $query->where('status', $status);
        })->where('user_id', $user_id)->orderBy('id', 'desc')->paginate($limit);

        return $this->success('', $lever_transaction);
    }

    //原LevelController  submit方法              提交合约交易
    public function submit()
    {
        $isoLever = transaction(function () {
            $currency_match_id = request('currency_match_id');
            $price = request('price', 0);
            $share = request('share');
            $multiple = request('multiple');
            $type = request('type');
            return IsoLever::submit($currency_match_id, $price, $share, $multiple, $type);
        });
        $isoLever->syncToWorker();
        return $this->success(__("api.提交成功"));
    }

    /**
     * 设置止盈止损
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ThrowException
     */
    public function setStopPrice()
    {
        return transaction(function () {
            $user_set_stopprice = Setting::getValueByKey('user_set_stopprice', 0);
            if (!$user_set_stopprice) {
                return $this->error(__('api.此功能系统未开放'));
            }
            $id = request('id');
            $target_profit_price = request('target_profit_price');
            $stop_loss_price = request('stop_loss_price');
            if ($target_profit_price <= 0 || $stop_loss_price <= 0) {
                return $this->error(__('api.止盈止损价格不能为0'));
            }
            $order = IsoLever::find($id);
            if (!$order) {
                return $this->error(__('api.参数错误'));
            }
            $order->setStop($target_profit_price, $stop_loss_price);
            return $this->success(__('api.设置成功'));
        });
    }

    /**
     * 平仓
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ThrowException
     */
    public function close()
    {
        return transaction(function () {
            $id = request("id");
            $order = IsoLever::find($id);
            if (!$order) {
                return $this->error(__('api.参数错误'));
            }
            $order->close(IsoLever::CLOSE_USER);
            return $this->success(__("api.操作成功"));
        });
    }

    //原LevelController  batchCloseByType方法    批量平仓 按照买卖方向

    public function batchCloseByType()
    {
        return transaction(function () {
            $user_id = User::getUserId();
            $type = request('type');
            $currency_match_id = request('currency_match_id');
            $currency_match = CurrencyMatch::findOrFail($currency_match_id);
            if (!$currency_match_id || !$type) {
                return $this->error(__('api.参数错误'));
            }
            foreach (IsoLever::where('user_id', $user_id)
                         ->where('status', IsoLever::STATUS_TX)
                         ->where('currency_match_id', $currency_match->id)
                         ->when($type, function ($query, $type) {
                             $query->where('type', $type);
                         })->get() as $item) {
                $item->close(IsoLever::CLOSE_USER);
            }
            return $this->success(__('api.提交成功,请等待系统处理'));
        });
    }

    /**
     * 撤单
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ThrowException
     */
    public function cancel()
    {
        return transaction(function () {
            $id = request("id");
            $order = IsoLever::find($id);
            if (!$order) {
                return $this->error(__('api.参数错误'));
            }
            $order->cancel();
            return $this->success(__("api.操作成功"));
        });
    }
}
