<?php

namespace App\Http\Middleware;

use App\Models\Admin\Admin;
use App\Models\Admin\AdminModule;
use App\Models\Admin\AdminModuleAction;
use App\Models\Admin\OperationLog;
use App\Models\Route\AdminRoute;
use App\Models\User\User;
use Closure;
use Illuminate\Http\Request;

/**设置用户的访问日志
 * Class SetOperationLog
 *
 * @package App\Http\Middleware
 */
class IndexLog
{
    const NO_INSERT_PARAMS_ROUTES = [

    ];

    public function handle(Request $request, Closure $next)
    {
        $user_id = User::getUserId();
        $user = User::where('id',$user_id)->first();
        $email = '';
        if ($user){
            $email = $user['email'];
        }
        $arr = explode('?', $request->getRequestUri());
        if (count($arr) != 0) {

                    $parameter = serialize($request->all());
                    $operation = new \App\Models\Route\IndexLog();
                    $operation->ip = $request->ip();
                    $operation->email = $email;
                    $operation->method = $request->method();
                    $operation->request_path = $request->getRequestUri();
                    $operation->data = $parameter;
                    $operation->save();
        }

        return $next($request);
    }
}
