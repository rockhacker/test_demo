<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\ThrowException;
use App\Models\Follow\Follow;
use App\Models\User\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function followAccount()
    {
        try{

            DB::beginTransaction();

            $user_id = User::getUserId();

            $ex = Follow::where("user_id",$user_id)->first();

            if ($ex) {

                if ($ex->status == 1){
                    throw new ThrowException(__('model.正在跟随中'), 404);
                }
                Follow::where("user_id",$user_id)->update([
                    "status" => 1
                ]);

            }else{

                Follow::insert([
                    "user_id"=>$user_id,
                    "status"=>1//跟随中
                ]);
            }

            DB::commit();

            return $this->success(__('api.请求成功'));
        }catch (Exception $ex){

            DB::rollBack();
            return $this->error($ex->getMessage());
        }



    }


}
