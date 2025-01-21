<?php

namespace App\Http\Middleware;

use App\Models\Follow\Follow;
use App\Models\User\User;
use Closure;
use Illuminate\Http\Request;

class CheckFollowLock
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $manager = User::getIsFollower();

        if($manager == 1){
            //如果是跟单员直接通过
            return $next($request);
        }

        $user_id = User::getUserId();

        if (Follow::where("user_id",$user_id)->where("status",1)->exists()){

            return json_response_error(__('api.正在跟单无法操作'));
        }

        return $next($request);
    }
}
