<?php

/**
 * Created by PhpStorm.
 * User: LDH
 */

namespace App\Models\User;

use App\Models\Model;

class Token extends Model
{

    /**获取token值
     *
     * @return string
     */
    public static function getToken()
    {
        return request()->header('AUTHORIZATION', '');
    }

    /**设置token
     *
     * @param $user_id
     * @param $timeout_days
     * @param $follower 0普通登陆 1操盘手登陆
     *
     * @return string
     */
    public static function setToken($user_id, $timeout_days = 1,$follower = 0)
    {
        $token = md5($user_id . time() . rand(0, 99999));

        self::create([
            'user_id' => $user_id,
            'timeout_at' => now()->addDays($timeout_days),
            'token' => $token,
            'follower'=>$follower
        ]);
        return $token;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**根据token获取user_id
     *
     * @param $token
     *
     * @return int
     */
    public static function getUserIdByToken($token)
    {
        if (empty($token)) {
            return 0;
        }
        $token = self::where('token', $token)->first();
        if (empty($token)) {
            return 0;
        }
        return $token->user_id;
    }

    /**根据token获取follower
     * @param $token
     *
     * @return int
     */
    public static function getFollowerByToken($token)
    {
        return self::where('token', $token)->value("follower");
    }
}
