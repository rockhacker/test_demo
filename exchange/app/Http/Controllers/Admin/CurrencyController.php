<?php


namespace App\Http\Controllers\Admin;

use App\BlockChain\BlockChain;
use App\Http\Requests\Admin\Currency\CurrencySaveRequest;
use App\Http\Requests\Admin\Currency\CurrencyUpdateRequest;
use App\Models\Account\AccountType;
use App\Models\Currency\Currency;
use App\Models\Setting\Setting;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CurrencyController extends Controller
{

    public function index()
    {
        return view('admin.currency.index');
    }

    public function delete()
    {
        $id = request('id', 0);
        Currency::destroy($id);
        return $this->success('删除成功');
    }

    public function list()
    {
        $limit = request('limit', 10);
        $list = Currency::paginate($limit);
        return $this->layuiPageData($list);
    }

    public function add()
    {
//        abort(403, '添加功能已关闭');
        $account_types = AccountType::where('is_display', AccountType::STATUS_ON)->get();
        return view('admin.currency.add', [
            'account_types' => $account_types
        ]);
    }

    public function save(CurrencySaveRequest $request)
    {
        return $this->error('演示环境禁止修改');

        $data = $request->validationData();
        $data = array_map(function ($item) {
            if (is_array($item)) {
                $item = array_values($item);
            }
            return $item;
        }, $data);
        if(!isset($data['accounts_display'])){
            $data['accounts_display']=[];
        }
        $currency = Currency::create($data);
        return $this->success('添加成功');
    }

    public function edit()
    {
        $id = request('id', 0);
        $currency = Currency::find($id);
        $account_types = AccountType::where('is_display', AccountType::STATUS_ON)->get();

        return view('admin.currency.edit', [
            'currency' => $currency,
            'account_types' => $account_types
        ]);
    }

    public function update(CurrencyUpdateRequest $request)
    {
        return $this->error('演示环境禁止修改');
        $id = $request->input('id', 0);
        $data = $request->validationData();
        $data['accounts_display']=array_values($data['accounts_display']);
        $currency = Currency::findOrFail($id);
        $currency->update($data);

        return $this->success('更改成功');
    }

    /**
     * @return JsonResponse
     * @throws Throwable
     */
    public function executeCurrency(): JsonResponse
    {
        $id = request('id', 0);

        $currency = Currency::findOrFail($id);
//
//        if (!$currency->currencyProtocols()->exists()) {
//            return $this->error('请至设置币种链上协议后再上币');
//        }

//        Artisan::queue('account:executeCurrency', [
//            'currency_id' => $id
//        ])->onQueue('executeCurrency');
        $currency = Currency::findOrFail($id);
        $user_count = User::count();

        //循环创建去中心化钱包
        foreach ($currency->currencyProtocols()->cursor() as $currencyProtocol) {
            $blockChain = BlockChain::newInstance($currencyProtocol);

            DB::transaction(function () use ($blockChain, $user_count) {
                foreach (User::cursor() as $k => $user) {
                    $blockChain->generateOnlineWallet($user);

                }
            });
        }

        foreach (User::cursor() as $k => $user) {
            DB::transaction(function () use ($user, $currency, $user_count, $k) {
                //创建中心化账户
                AccountType::generateUserAccount($user, $currency);
            });
        }
//        return $this->success('已经将申请放入队列,请稍候');
        return $this->success('已更新');
    }

}
