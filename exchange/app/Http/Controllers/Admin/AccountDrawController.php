<?php

namespace App\Http\Controllers\Admin;

use App\BlockChain\BlockChain;
use App\Exceptions\ThrowException;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Chain\ChainProtocol;
use App\Models\Chain\TxHash;
use App\Models\Currency\CurrencyProtocol;
use App\Models\User\User;
use App\Models\Account\AccountDraw;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class AccountDrawController extends Controller
{
    public function index()
    {
        return view('admin.accountDraw.index');
    }

    public function list()
    {
        $uid = request('uid', '');
        $email = request('email', '');
        $mobile = request('mobile', '');
        $limit = request('limit', 15);
        $status = request('status', 0);

        $list = AccountDraw::with(['user', 'currency'])->when($uid, function ($query, $uid) {
            $query->whereHas('user', function ($query) use ($uid) {
                $query->where('uid', $uid);
            });
        })->when($email, function ($query, $email) {
            $query->whereHas('user', function ($query) use ($email) {
                $query->where('email', $email);
            });
        })->when($mobile, function ($query, $mobile) {
            $query->whereHas('user', function ($query) use ($mobile) {
                $query->where('mobile', $mobile);
            });
        })->when($status, function ($query, $status) {
            $query->where('status', $status);
        })->orderBy('status', 'ASC')->orderBy('id', 'DESC')->paginate($limit);

        return $this->layuiPageData($list);
    }

    /**
     * 跳转到单独页面
     *
     * @return Factory|View
     */
    public function detail()
    {
        //获取到id
        $id = request('id');

        $info = AccountDraw::findOrFail($id);
        $chain_id = CurrencyProtocol::where("id",$info->currency_protocol_id)->value("chain_protocol_id");

        $pName = ChainProtocol::where('id',$chain_id)->value("code");

        return view('admin.accountDraw.detail', ['info' => $info,"pName"=>$pName]);
    }

    /**
     * 通过审核
     *
     * @return JsonResponse
     * @throws ThrowException
     */
    public function confirm()
    {
        return transaction(function () {
            $id = request('id', 0);
            $code = request('code', 0);
            $use_chain_api = request('use_chain_api', 0);
            $notes = request('notes', '');

            //判断是否使用链上
            if ($use_chain_api != 1 && strlen($notes) <= 0) {
                return $this->error('请填写备注或使用链上接口');
            }

            $out = AccountDraw::with('currency')->lockForUpdate()->find($id);
            if (!$out || $out->status != AccountDraw::STATUS_WAIT) {
                return $this->error('当前状态无法操作');
            }
            /**@var AccountDraw $out**/
            $out->confirm($use_chain_api,$notes,$code);

            return $this->success('操作成功');
        });
    }

    /**驳回申请
     *
     * @return JsonResponse
     * @throws ThrowException
     */
    public function reject()
    {
        return transaction(function () {
            $id = request('id', 0);
            $out = AccountDraw::lockForUpdate()->find($id);
            $notes = request('notes', '');
            if (!$out || $out->status != AccountDraw::STATUS_WAIT) {
                return $this->error('当前状态无法操作');
            }

            $out->reject($notes);

            return $this->success('驳回成功');
        });
    }

    public function del()
    {
        $id = request('id', 0);
        AccountDraw::destroy($id);

        return $this->success('删除成功');

    }

}
