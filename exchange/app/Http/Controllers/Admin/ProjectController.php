<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\Project\ProjectEditRequest;
use App\Http\Requests\Admin\Project\ProjectSaveRequest;
use App\Logic\Market;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyMatch;
use App\Models\Project\Project;
use App\Models\Project\ProjectRobotPeriods;
use App\Models\Project\ProjectRobots;
use App\Models\Project\SubProject;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function project_index()
    {

        return view('admin.project.project_index');
    }

    /**
     * @return Application|Factory|View
     */
    public function add_project()
    {

        $currencies =  Currency::where("is_new",1)->get();

        return view('admin.project.add_project',[
            'currencies'=>$currencies
        ]);
    }


    /**
     * @param ProjectSaveRequest $request
     * @return JsonResponse
     */
    public function save_project(ProjectSaveRequest $request): JsonResponse
    {

        $data = $request->validationData();
        $data = array_map(function ($item) {
            if (is_array($item)) {
                $item = array_values($item);
            }
            return $item;
        }, $data);
        if(Project::where("currency_id",$data['currency_id'])
            ->where("end_time",">",date("Y-m-d H:i:s"))->exists()){

            return $this->error("该币种认购中/未开始");
        }

        $time_explode = explode(" - ",$data['range_time']);
        unset($data['range_time']);
        $data['start_time'] = $time_explode[0];
        $data['end_time'] = $time_explode[1];
        Project::create($data);
        return $this->success('添加成功');
    }


    /**
     * @return JsonResponse
     */
    public function project_list(): JsonResponse
    {

        $limit = request('limit', 10);
        $list = Project::with(['currency'])->paginate($limit);
        return $this->layuiPageData($list);

    }

    /**
     * @return Application|Factory|View
     */
    public function project_edit()
    {

        $id = request('id',0);
        $project = Project::find($id);
        $currencies =  Currency::where("is_new",1)->get();

        return view("admin.project.edit_project",[
            'project'=>$project,
            'currencies'=>$currencies
        ]);
    }

    /**
     * @param ProjectEditRequest $request
     * @return JsonResponse
     */
    public function edit_project_post(ProjectEditRequest $request)
    {
        $data = $request->validationData();
        $data = array_map(function ($item) {
            if (is_array($item)) {
                $item = array_values($item);
            }
            return $item;
        }, $data);
        $project_id = $data['id'];
        unset($data['id']);
        Project::where('id',$project_id)->update($data);
        return $this->success('修改成功');
    }

    /**
     * @return JsonResponse
     */
    public function project_del(): JsonResponse
    {
        $i = request('id',0);

        Project::destroy($i);

        return $this->success('删除成功');
    }

    /**
     * @return Application|Factory|View
     */
    public function project_sub_show()
    {
        $id = request("id",0);
        return view("admin.project.project_sub_show",['id'=>$id]);
    }

    /**
     * @return JsonResponse
     */
    public function project_sub_show_list(): JsonResponse
    {
        $id = request("id",0);
        $limit = request('limit', 10);

        $list = SubProject::with("user")->where("project_id",$id)->paginate($limit);
        return $this->layuiPageData($list);
    }


    /**
     * @return Application|Factory|View
     */
    public function robot_index()
    {

        return view("admin.project.robot_index");
    }

    /**
     * @return Application|Factory|View
     */
    public function add_project_robot()
    {
        $currency_match = CurrencyMatch::get();
        return view("admin.project.add_project_robot",[
            'currency_match'=>$currency_match
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function save_project_robot(): JsonResponse
    {
        $currency_match_id = request("currency_match_id",0);
        $open_price = request("open_price",0);
        $min_default_change = request("min_default_change",0.001);
        $max_default_change = request("max_default_change",0.003);

        if($open_price <= 0){

            return $this->error("开盘价格必须大于0");
        }
        if(ProjectRobots::where("currency_match_id",$currency_match_id)->exists()){

            return $this->error("该币种已经存在机器人");
        }
        $process_id = ProjectRobots::orderByDesc("process_id")->value('process_id')??0;
        $process_id++;
        $r = [
            'currency_match_id'=>$currency_match_id,
            'open_price'=>$open_price,
            'min_default_change'=>$min_default_change,
            'max_default_change'=>$max_default_change,
            'process_id'=>$process_id,
            'current_price'=>$open_price,
        ];
        ProjectRobots::create($r);

        return $this->success("保存成功");
    }

    /**
     * @return JsonResponse
     */
    public function project_robot_list(): JsonResponse
    {
        $limit = request('limit', 10);

        $list = ProjectRobots::with(['currencyMatch'])->paginate($limit);
        return $this->layuiPageData($list);
    }

    /**
     * @return Application|Factory|View
     */
    public function edit_project_robot()
    {
        $id = request("id",0);
        $robot = ProjectRobots::find($id);
        return view("admin.project.edit_project_robot",[
            'robot'=>$robot
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function update_project_robot(): JsonResponse
    {
        $id = request("id",0);

        $min_default_change = request("min_default_change",0.003);
        $max_default_change = request("max_default_change",0.010);

        ProjectRobots::where("id",$id)->update([
            "min_default_change"=>$min_default_change,
            "max_default_change"=>$max_default_change
        ]);
        return $this->success("修改成功");

    }

    /**
     * @return JsonResponse
     */
    public function project_robot_del(): JsonResponse
    {

        $id = request("id",0);

        ProjectRobots::destroy($id);

        return $this->success("删除成功");
    }

    /**
     * @return Application|Factory|View
     */
    public function project_robot_change_set()
    {
        $id = request("id",0);
        return view("admin.project.project_robot_change_set",[
            'id'=>$id
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function project_robot_change_list(): JsonResponse
    {

        $id = request("id",0);
        $limit = request('limit', 10);

        $list = ProjectRobotPeriods::where('robot_id',$id)->paginate($limit);
        foreach($list as $key => $value){
            $value->period = substr($value->period,0,8);
            $value->all_change = round($value->all_change*100,4);
        }

        return $this->layuiPageData($list);

    }


    /**
     * @return Application|Factory|View
     */
    public function add_project_robot_period()
    {
        $id = request("robot_id",0);
        return view("admin.project.add_project_robot_period",[
            'id'=>$id
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function save_project_robot_period(): JsonResponse
    {
        /**
         * @var string $id
         */
        $id = request("id","");
        $change = request("change",[]);
        $day_close_price = request("day_close_price",[]);
        /**
         * @var string $period
         */
        $period = request("period","");

        if(!$period){

            return $this->error("请选择日期");
        }

        if(ProjectRobotPeriods::where("period",$period.$id)
            ->where("robot_id",$id)
            ->exists()){

            return $this->success("该日期已存在");
        }
        $all_change = 0;
        foreach($change as $key => $value){

            $all_change+= $value;
        }

        ProjectRobotPeriods::create([
            'change'=>json_encode($change),
            'all_change'=>json_encode($all_change),
            'period'=>$period.$id,
            'robot_id'=>$id,
            'day_close_price'=>json_encode($day_close_price),
        ]);

        return $this->success("添加成功");

    }

    /**
     * @return JsonResponse
     */
    public function project_robot_period_del(): JsonResponse
    {
        $id = request("id",0);

        ProjectRobotPeriods::destroy($id);

        return $this->success("删除成功");

    }


    public function edit_project_robot_period()
    {
        $id = request("id",0);
        $period = ProjectRobotPeriods::find($id);
        $period->period = substr($period->period,0,8);
        $period->change = json_decode($period->change,true);

        $period->day_close_price = json_decode($period->day_close_price,true);
        return view("admin.project.edit_project_robot_period",[
            'period'=>$period
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function update_project_robot_period(): JsonResponse
    {
        $id = request("id",0);
        $change = request("change",[]);
        $day_close_price = request("day_close_price",[]);

        /**
         * @var string $period
         */
        $period = request("period","");

        if(!$period){

            return $this->error("请选择日期");
        }

        $data = ProjectRobotPeriods::findOrFail($id);
        $all_change = 0;
        foreach($change as $key => $value){

            $all_change+= $value;
        }
        $data->period = $period.$data->robot_id;
        $data->all_change = json_encode($all_change);
        $data->change = json_encode($change);
        $data->day_close_price = json_encode($day_close_price);
        $data->save();

        return $this->success("修改成功");
    }

    public function robot_push_price()
    {
        $id = request("id",0);

        return view("admin.project.robot_push_price",[
            "id"=>$id,
        ]);
    }

    public function save_robot_new_price()
    {
        $id = request("id",0);
        $price = request("price",0);

        $robot = ProjectRobots::find($id);

        if($price <= 0){

            return $this->error("推送价格不能小于或等于0");
        }
        $robot->push_price = $price;
        $robot->save();

        return $this->success("推送成功，请等待处理");
    }


    public function show_kline()
    {
        $id = request("id",0);
        return view("admin.project.show_kline",[
            "id"=>$id,
            "p"=>Market::PERIODS
        ]);
    }


    public function edit_kline()
    {
        //k线id
        $id = request("id",0);

        //期
        $p = request("p","1min");

        $currency_match_id = request("currency_match_id",0);

        $currency = CurrencyMatch::find($currency_match_id);

        if(empty($currency)){

            return $this->error("无法找到该交易对");
        }

        $kline = Market::getKline($currency->symbol, $p, Market::KLINE_SIZE)->toArray();
        $data = [];
        foreach($kline as $key => $value){
            if($value->id == $id){
                $data = $value;
            }
        }

        return view("admin.project.edit_kline",[
            "data"=>$data,
        ]);
    }

    public function get_kline_data()
    {

        $id = request("id",0);
        $p = request("p","1min");

        $robot = ProjectRobots::where("id",$id)->first();

        $currencyMatch = CurrencyMatch::find($robot->currency_match_id);

        $kline = Market::getKline($currencyMatch->symbol, $p, Market::KLINE_SIZE);

        return response()->json([
            'code' => 0,
            'msg' => "获取成功",
            'count' => 300,
            'data' => $kline->sortKeysDesc()->toArray(),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function save_kline()
    {
        //k线id
        $id = request("id",0);
        $open = request("open",0);
        $close = request("close",0);
        $high = request("high",0);
        $low = request("low",0);
        $p = request("p","1min");
        $currency_match_id = request("currency_match_id",0);

        $currency = CurrencyMatch::find($currency_match_id);

        if(empty($currency)){

            return $this->error("无法找到该交易对");
        }

        $kline = Market::getKline($currency->symbol, $p, Market::KLINE_SIZE)->toArray();
        foreach($kline as $key => &$value){
            if($value->id == $id){
                $value->open = $open;
                $value->close = $close;
                $value->high = $high;
                $value->low = $low;
            }
        }
        ksort($kline);
        $key = "kline:{$currency->symbol}:".$p;
        Cache::forever($key, $kline);

        return $this->success("保存成功");

    }

    public function del_kline()
    {

        //k线id
        $id = request("id",0);
        $currency_match_id = request("currency_match_id",0);
        $p = request("p","1min");
        $currency = CurrencyMatch::find($currency_match_id);

        if(empty($currency)){

            return $this->error("无法找到该交易对");
        }

        $kline = Market::getKline($currency->symbol, $p, Market::KLINE_SIZE)->toArray();
        $del_key = -1;
        foreach($kline as $key => &$value){
            if($value->id == $id){
                $del_key = $key;
            }
        }

        if($del_key >= 0){

            unset($kline[$del_key]);
            ksort($kline);
            $key = "kline:{$currency->symbol}:".$p;
            Cache::forever($key, $kline);

            return $this->success("删除成功");
        }else{

            return $this->error("无法找到该k线");
        }

    }
}
