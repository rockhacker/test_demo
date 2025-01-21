<?php


namespace App\Http\Controllers\Admin;


use App\Models\Prizes\Prizes;
use App\Models\Prizes\PrizesInfo;
use App\Models\Prizes\PrizesOrder;
use App\Models\Prizes\PrizesWin;
use App\Models\System\Lang;
use App\Models\User\User;
use Illuminate\Http\Request;

class PrizesController extends Controller
{
    public function index()
    {
        return view('admin.prizes.index');
    }

    public function list(Request $request)
    {
        $prizes = Prizes::paginate();
        return $this->layuiPageData($prizes);
    }

    public function edit(Request $request)
    {
        $id = $request->input('id',0);
        $prizes = Prizes::find($id);
        return view('admin.prizes.edit',['prizes' => $prizes]);
    }

    public function update(Request $request)
    {
        $data = $request->input();
        $prizes = Prizes::find($data['id']);

        $prizes->update($data);

        return $this->success('修改成功');
    }

    public function infoList(Request $request)
    {
        if($request->method() == 'POST'){
            $limit = request('limit', 10);
            $lang = request('lang_id', -0);
            $prizes_id = request('prizes_id', -1);

            $infos = PrizesInfo::with(['prizes','lang'])->when($lang > 0,function ($q)use($lang){
                return $q->where('lang_id',$lang);
            })->when($prizes_id  > 0,function ($q)use($prizes_id){
                return $q->where('prizes_id',$prizes_id);
            })->paginate($limit);
            return $this->layuiPageData($infos);
        } else {
            $prizes = Prizes::all();
            $lang = Lang::all();
            return view('admin.prizes.info_list',['prizes' => $prizes ,'langs' => $lang]);
        }
    }
    public function infoAdd(Request $request)
    {
        if($request->method() == 'POST'){
            $data = $request->input();

            if(empty($data['prizes_id']) || empty($data['lang_id']) || empty($data['name'])){
                return $this->error('必要参数不能为空');
            }

            PrizesInfo::create([
                'prizes_id' => $data['prizes_id'],
                'name' => $data['name'],
                'img' => $data['img'],
                'description' => $data['description'],
                'lang_id' => $data['lang_id'],
            ]);
            return $this->success('添加成功');
        } else {
            $prizes = Prizes::all();
            $lang = Lang::all();
            return view('admin.prizes.info_add',['prizes' => $prizes ,'langs' => $lang]);
        }
    }

    public function infoEdit(Request $request)
    {
        $data = $request->input();

        $info = PrizesInfo::find($data['id']);

        if($request->method() == 'POST'){

            if(empty($info) || empty($data['prizes_id']) || empty($data['lang_id']) || empty($data['name'])){
                return $this->error('必要参数不能为空');
            }

            unset($data['file']);

            $info->update($data);

            return $this->success('编辑成功');

        } else {
            $prizes = Prizes::all();
            $lang = Lang::all();
            return view('admin.prizes.info_edit',['info' => $info,'prizes' => $prizes ,'langs' => $lang]);
        }
    }

    public function infoDel(Request $request)
    {
       $prizes_info = PrizesInfo::find($request->input('id'));
       if(empty($prizes_info)){
           return $this->error('数据不存在');
       }

       $prizes_info->delete();

       return $this->success('删除成功');
    }

    public function winList(Request $request)
    {
        if($request->method() == 'POST'){
            $limit = request('limit', 10);
            $uid = request('uid', '');
            $email = request('email', '');
            $status = request('status', -1);
            $prizes_id = request('prizes_id', -1);

            $infos = PrizesWin::with(['prizes','user'])->when($status > 0,function ($q)use($status){
                return $q->where('status',$status);
            })->when($uid,function ($q)use($uid){
                $user = User::where('uid',$uid)->first();
                return $q->where('user_id', $user->id ?? 'false');
            })->when($email,function ($q)use($email){
                $user = User::where('email',$email)->first();
                if(!empty($user)){
                    return $q->where('user_id',$user->id ?? 'false');
                }
                return false;
            })->when($prizes_id  > 0,function ($q)use($prizes_id){
                return $q->where('prizes_id',$prizes_id);
            })->paginate($limit);
            return $this->layuiPageData($infos);
        } else {
            $prizes = Prizes::all();
            return view('admin.prizes.win_list',['prizes' => $prizes]);
        }
    }

    public function winAdd(Request $request)
    {
        if($request->method() == 'POST'){
            $data = $request->input();

            if(empty($data['prizes_id']) || empty($data['uid'])){
                return $this->error('必要参数不能为空');
            }

            $user = User::where('uid',$data['uid'])->first();
            if(empty($user)){
                return $this->error('用户不存在');
            }

            PrizesWin::create([
                'prizes_id' => $data['prizes_id'],
                'user_id' => $user['id'],
                'status' => PrizesWin::WAIT
            ]);
            return $this->success('添加成功');
        } else {
            $prizes = Prizes::all();
            return view('admin.prizes.win_add',['prizes' => $prizes ]);
        }
    }


    public function winDel(Request $request)
    {
        $prizes_info = PrizesWin::find($request->input('id'));
        if(empty($prizes_info)){
            return $this->error('数据不存在');
        }

        $prizes_info->delete();

        return $this->success('删除成功');
    }

    public function orderList(Request $request)
    {
        if($request->method() == 'POST'){
            $limit = request('limit', 10);
            $uid = request('uid', '');
            $email = request('email', '');
            $prizes_id = request('prizes_id', -1);

            $infos = PrizesOrder::with(['prizes','user'])->when($uid,function ($q)use($uid){
                $user = User::where('uid',$uid)->first();
                return $q->where('user_id', $user->id ?? 'false');
            })->when($email,function ($q)use($email){
                $user = User::where('email',$email)->first();
                if(!empty($user)){
                    return $q->where('user_id',$user->id ?? 'false');
                }
                return false;
            })->when($prizes_id  > 0,function ($q)use($prizes_id){
                return $q->where('prizes_id',$prizes_id);
            })->paginate($limit);
            return $this->layuiPageData($infos);
        } else {
            $prizes = Prizes::all();
            return view('admin.prizes.order_list',['prizes' => $prizes]);
        }
    }
}
