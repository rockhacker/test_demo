<?php

namespace App\Http\Controllers\Api;

use App\BlockChain\BlockChain;
use App\CoinDriver\Coin;
use App\Exceptions\ThrowException;
use App\Http\Controllers\Controller;
use App\Models\Chain\ChainProtocol;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyProtocol;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BlockChainController extends Controller
{

    /**推送充币接口
     *
     * @return JsonResponse
     * @throws ThrowException
     */
    public function apiRecharge()
    {
        return transaction(function () {
            $host = request()->ip();
            $node_server_host = config('go.node_server_host');
            $request_host = parse_url($node_server_host, PHP_URL_HOST);
            if ($host != $request_host) {
                return $this->error('非法请求');
            }

            $data = request()->all();
            BlockChain::parseApiRechargeData($data);
            return response()->json([
                'type' => 'ok'
            ]);
        });
    }

    /**获取所有的币种协议
     *
     */
    public function currencyProtocols()
    {
        $filter = request("filter",0);

        $currencies = Currency::with(['currencyProtocols' => function ($query) {
            /**@var $query Builder* */
            $query->select(['id', 'chain_protocol_id', 'currency_id', 'token_address']);
            $query->with('chainProtocol:id,code');
        }])->where('open_draw', 1)->get(['id', 'code','logo']);

//        $currencies->each(function($currency){
//            $currencyProtocol->append('');
//        });
        return $this->success(__('api.请求成功'), $currencies);
    }

    /**获取所有的区块链 协议
     *
     */
    public function chainProtocols()
    {
        $chain_protocols = ChainProtocol::get();
        return $this->success(__('api.请求成功'), $chain_protocols);
    }
}
