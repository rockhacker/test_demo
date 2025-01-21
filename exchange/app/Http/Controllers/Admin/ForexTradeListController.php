<?php
/**
 * Created by PhpStorm.
 * User: YSX
 * Date: 2019/3/21
 * Time: 14:17
 */

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\Forex\TradeList\TradeListUpdateRequest;
use App\Http\Requests\Admin\Forex\TradeList\TradeListSaveRequest;
use App\Models\BasicSet\BasicSet;
use App\Models\Forex\ForexQuotation;
use App\Models\Forex\ForexQuotationRobot;
use App\Models\Forex\ForexTradeList;
use Illuminate\Http\Request;

class ForexTradeListController extends Controller
{

    public function index()
    {
        return view('admin.forexTradeList.index');
    }

    public function list()
    {

        $limit = request()->input('limit', 10);
        $code = \request()->input('code','');
        $results = ForexTradeList::when($code,function ($q) use ($code){
            $q->where('code', 'like', "%$code%");
        })->paginate($limit);
        return $this->layuiPageData($results);
    }

    /**币种新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.forexTradeList.add');
    }

    /**币种保存
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        return $this->error('演示环境禁止修改');

        $data = $request->all();
        $data = array_map(function ($item) {
            if (is_array($item)) {
                $item = array_values($item);
            }
            return $item;
        }, $data);
        if(!empty($data['market_day'])){
            $market_start_day = new \stdClass();
            foreach($data['market_day'] as $key => $v){
                $date = explode(' - ',$v);
                $market_start_day->$key = ['start' => $date[0],'end' => $date[1]];
            }
            $data['market_start_day'] = json_encode($market_start_day,true);
        }
        if(ForexTradeList::where('code',$data['code'])->exists()){
            return $this->error('品种已存在');
        }
        unset($data['market_day']);
        $forex = ForexTradeList::create($data);
        ForexQuotation::create([
            'forex_id' => $forex->id,
        ]);

        ForexQuotationRobot::create([
            'forex_id' => $forex->id,
            'decimal' => 6,
            'status' => 1,
            'virtual' => $data['code'],
        ]);
        return $this->success('添加成功');
    }

    /**币种编辑
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $id = request('id', 0);
        $info = ForexTradeList::find($id);

        $info->market_start_day = json_decode($info->market_start_day,true);
        return view('admin.forexTradeList.edit', [
            'info' => $info,
        ]);
    }

    /**币种更新
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        return $this->error('演示环境禁止修改');

        $id = $request->input('id', 0);
        $data = $request->all();
        $currency = ForexTradeList::findOrFail($id);
        if(!empty($data['market_day'])){
            $market_start_day = new \stdClass();
            foreach($data['market_day'] as $key => $v){
                $date = explode(' - ',$v);
                $market_start_day->$key = ['start' => $date[0],'end' => $date[1]];
            }
            $data['market_start_day'] = json_encode($market_start_day,true);
        }

        if(ForexTradeList::where("id","!=",$id)->where('code',$data['code'])->exists()){
            return $this->error('品种已存在');
        }
        unset($data['market_day']);
        $currency->update($data);
        return $this->success('操作成功');
    }

    /**币种删除
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete()
    {
        return $this->error('演示环境禁止修改');

        $id = request('id', 0);
        ForexTradeList::destroy($id);
        return $this->success('删除成功');
    }

    public function batchSetFee(){
        if(\request()->getMethod() == 'POST'){
            $fee = request('trade_fee');
            $res = ForexTradeList::where('trade_status' , ForexTradeList::ON)->update(['forex_fee_rate' => $fee]);
            if($res){
                return $this->success('修改成功');
            }
            return $this->error('修改失败');
        } else {
            $basicSet = BasicSet::find(1);
            return view('admin.forexTradeList.batchSetFee',['trade_fee_type' => $basicSet->trade_fee_type]);
        }
    }
}
