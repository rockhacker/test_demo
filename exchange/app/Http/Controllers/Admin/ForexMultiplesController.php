<?php
/**
 * Created by PhpStorm.
 * User: YSX
 * Date: 2019/3/21
 * Time: 14:17
 */

namespace App\Http\Controllers\Admin;

use App\Models\Currency\Currency;
use App\Models\Forex\ForexMultiple;
use App\Models\Forex\ForexSettleCurrency;
use App\Models\Forex\ForexTradeList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForexMultiplesController extends Controller
{

    public function index()
    {
        return view('admin.forexMultiples.index');
    }

    public function list()
    {

        $limit = request()->input('limit', 10);

        $results = ForexMultiple::with('tradeList')->paginate($limit);
        return $this->layuiPageData($results);
    }

    /**计价币新增
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $tradeList = ForexTradeList::all();
        return view('admin.forexMultiples.add',[
            'tradeList' => $tradeList
        ]);
    }

    /**计价币保存
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $data = $request->all();
        ForexMultiple::create($data);
        return $this->success('添加成功');
    }

    /**计价币编辑
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $id = request('id', 0);

        $info = ForexMultiple::find($id);
        $tradeList = ForexTradeList::all();
        return view('admin.forexMultiples.edit', [
            'result' => $info,
            'tradeList' => $tradeList
        ]);
    }

    /**计价币更新
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $id = $request->input('id', 0);
        $data = $request->all();

        if(ForexMultiple::where('id',$id)->doesntExist()){
            return $this->error('数据不存在');
        }
        $currency = ForexMultiple::findOrFail($id);
        $currency->update($data);
        return $this->success('操作成功');
    }

    /**计价币删除
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete()
    {
        $id = request('id', 0);
        ForexMultiple::destroy($id);
        return $this->success('删除成功');
    }
}
