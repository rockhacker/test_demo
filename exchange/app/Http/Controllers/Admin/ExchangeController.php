<?php


namespace App\Http\Controllers\Admin;

use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Exceptions\ThrowException;
use App\Models\Account\ExchangeLog;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Throwable;


class ExchangeController extends Controller
{
    public function index()
    {

        return view('admin.exchange.index');
    }

    public function getData()
    {
        $limit = request('limit', 10);
        $uid = request('uid', 0);
        $email = request('email', '');

        $list = ExchangeLog::with(['user','baseCurrency','quoteCurrency'])
            ->when($uid, function ($query, $uid) {
                $user_id = User::where('uid', $uid)->value('id');
                $query->where('user_id', $user_id);
            })->when($email, function ($query, $email) {
                $user_id = User::where('email', $email)->value('id');
                $query->where('user_id', $user_id);
            })->orderByDesc('id')->paginate($limit);

        return $this->layuiPageData($list);
    }

}
