<?php
/**
 * Created by PhpStorm.
 * User: YSX
 * Date: 2019/3/21
 * Time: 14:17
 */

namespace App\Http\Controllers\Admin;

use App\Models\Currency\Currency;
use App\Models\Forex\ForexSettleCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForexSettleCurrencyController extends Controller
{

    public function index()
    {
        return view('admin.forexSettleCurrency.index');
    }

    public function list()
    {

        $limit = request()->input('limit', 10);

        $results = ForexSettleCurrency::with('currency')->paginate($limit);
        return $this->layuiPageData($results);
    }

    /**计价币新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $currencies = Currency::get();
        return view('admin.forexSettleCurrency.add',[
            'currencies' => $currencies
        ]);
    }

    /**计价币保存
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'currency_name' => 'required|string|max:255',
            'settle_status' => 'required|integer',
            'logo' => 'required|url',
            'recharge_currency_id' => 'required|integer|min:1',
            'recharge_bili' => 'required|min:0',
        ], [], [
            'currency_name' => '币种每次',
            'settle_status' => '是否结算账户',
            'logo' => 'logo',
            'recharge_currency_id' => '兑换币',
            'recharge_bili' => '兑换比例',
        ]);
        //进行基本验证
        throw_if($validator->fails(), new \Exception($validator->errors()->first()));
        unset($data['file']);
        ForexSettleCurrency::create($data);
        return $this->success('添加成功');
    }

    /**计价币编辑
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $id = request('id', 0);

        $info = ForexSettleCurrency::find($id);
        $currencies = Currency::all();
        return view('admin.forexSettleCurrency.edit', [
            'info' => $info,
            'currencies' => $currencies
        ]);
    }

    /**计价币更新
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $id = $request->input('id', 0);
        $data = $request->all();
        $validator = Validator::make($data, [
            'currency_name' => 'required|string|max:255',
            'settle_status' => 'required|integer',
            'logo' => 'required|url',
            'recharge_currency_id' => 'required|integer|min:1',
            'recharge_bili' => 'required|min:0',
        ], [], [
            'currency_name' => '币种每次',
            'settle_status' => '是否结算账户',
            'logo' => 'logo',
            'recharge_currency_id' => '兑换币',
            'recharge_bili' => '兑换比例',
        ]);
        //进行基本验证
        throw_if($validator->fails(), new \Exception($validator->errors()->first()));

        if(ForexSettleCurrency::where('id',$id)->doesntExist()){
            return $this->error('币种不存在');
        }
        $currency = ForexSettleCurrency::findOrFail($id);
        unset($data['file']);
        $currency->update($data);
        return $this->success('操作成功');
    }

    /**计价币删除
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete()
    {
        $id = request('id', 0);
        ForexSettleCurrency::destroy($id);
        return $this->success('删除成功');
    }
}
