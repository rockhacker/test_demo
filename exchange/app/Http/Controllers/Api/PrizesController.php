<?php


namespace App\Http\Controllers\Api;


use App\Models\Prizes\Prizes;
use App\Models\Prizes\PrizesInfo;
use App\Models\Prizes\PrizesOrder;
use App\Models\Prizes\PrizesWin;
use App\Models\System\Lang;
use App\Models\User\User;
use Illuminate\Http\Request;

class PrizesController extends Controller
{
    public function list(Request $request)
    {
        $lang = $request->header('lang', 'en');
        $list = Prizes::get();

        $lang_id = Lang::where('code',$lang)->first();

        $infos = PrizesInfo::where(['lang_id' => $lang_id->id])->get()->keyBy('prizes_id')->all();
        foreach ($list as $k => $v) {
            $info = $infos[$v['id']] ?? null;
            $list[$k]['name'] = $info['name'] ?? $v['name'];
            $list[$k]['img'] = $info['img'] ?? '';
            $list[$k]['description'] = $info['description'] ?? '';
            unset($list[$k]['default_win']);
        }
        return $this->success('success',$list);
    }

    public function submit(Request $request)
    {
        $user_id = User::getUserId();
        $lang = $request->header('lang', 'en');

//        if(empty($user_id)){
//            return $this->error(__('api.请登录'));
//        }
        $user_id = 1;
        $start_time = date('Y-m-d').' 00:00:00';
        $end_time = date('Y-m-d').' 23:50:59';
        $already_submit = PrizesOrder::whereRaw("created_at >= '{$start_time}' && created_at <= '$end_time'")->where('user_id',$user_id)->exists();
        if($already_submit){
            return $this->error(__('api.您已经申请过了'));
        }

        $win_result = PrizesWin::where(['user_id' => $user_id,'status' => 0])->first();


        if($win_result){
            $default_prizes = Prizes::where(['id' => $win_result->prizes_id])->first();
        } else {
            $default_prizes = Prizes::where(['default_win' => 1])->first();
        }

        if(empty($default_prizes)){
            return $this->error(__('api.操作失败'));
        }

        \DB::beginTransaction();

        try {
            if($win_result){
                $win_result->status = 1;
                $win_result->used_at = date('Y-m-d H:i:s');
                $win_result->save();
            }

            PrizesOrder::create([
                'prizes_id' => $default_prizes->id,
                'user_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            \DB::commit();

            $lang_id = Lang::where('code',$lang)->first();

            $info = PrizesInfo::where(['lang_id' => $lang_id->id,'prizes_id' => $default_prizes->prizes_id])->first();

            $default_prizes->name = $info->name ?? $default_prizes->name;
            $default_prizes->img = $info->img ?? '';
            $default_prizes->description = $info->description ?? '';
            return $this->success(__('api.请求成功'),$default_prizes);
        } catch (\Exception $e){
            \DB::rollBack();
            return $this->error(__('api.操作失败'). $e->getMessage());
        }
    }

    public function lotteryRecord(Request $request)
    {
        $limit = request('limit', 10);

        $lang = $request->header('lang', 'en');

        $lang_id = Lang::where('code',$lang)->first();

        $infos = PrizesInfo::where(['lang_id' => $lang_id->id])->get()->keyBy('prizes_id')->all();

        $list = PrizesOrder::where('user_id', User::getUserId())->orderByDesc("id")->paginate($limit);


        foreach ($list as $k => $v) {
            $info = $infos[$v['id']];
            $list[$k]['name'] = $info['name'] ?? $v['name'];
            $list[$k]['img'] = $info['img'] ?? '';
            $list[$k]['description'] = $info['description'] ?? '';
        }
        return $this->success(__('api.请求成功'), $list);
    }
}
