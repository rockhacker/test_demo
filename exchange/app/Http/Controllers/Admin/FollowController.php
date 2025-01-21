<?php


namespace App\Http\Controllers\Admin;

use App\Models\Follow\Follow;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class FollowController extends Controller
{

    public function list(request $request)
    {
        if($request->method() == "POST"){

            $limit = $request->input('limit', 10);

            /** @var LengthAwarePaginator $res */
            $res = Follow::with('getUserInfo')
                ->where("status",1)
                ->orderBy('id', 'desc')
                ->paginate($limit);

            return $this->layuiPageData($res);

        }else{

            return view("admin.follow.list");
        }

    }

    public function cancel()
    {

        $id = request()->get("id",0);

        Follow::where("id",$id)->update([
            "status"=>0
        ]);

        return $this->success('取消成功');
    }

}
