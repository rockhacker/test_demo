<?php


namespace App\Http\Controllers\Admin;

use App\Models\Account\AccountLog;
use App\Models\Account\ChangeAccount;
use App\Models\Commission\CommissionLists;
use App\Models\Commission\SetCommission;
use App\Models\System\Area;
use App\Models\System\Lang;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\System\Payway;

class CommissionController extends Controller
{


    public function set()
    {
        return view("admin.commission.set", ['data' => SetCommission::find(1)]);
    }


    public function save(): JsonResponse
    {

        $customer_rate = request("customer_rate", 0);
        $agent_rate = request("agent_rate", 0);

        if ($customer_rate == "") {

            return $this->error("客户邀请百分比必须填写");
        }

        if ($customer_rate == "") {

            return $this->error("代理邀请百分比必须填写");
        }

        SetCommission::updateOrCreate(["id" => 1], [
            'agent_rate' => $agent_rate,
            'customer_rate' => $customer_rate,
        ]);

        return $this->success("更新成功");
    }

    public function list()
    {
        return view("admin.commission.list");
    }

    public function list_post(): JsonResponse
    {
        $limit = \request("limit", 0);

        $lists = CommissionLists::with([
            "toUserInfo",
            "fromUserInfo",
            'currency'
        ])->orderByDesc("id")->paginate($limit);

        return $this->layuiPageData($lists);
    }


    /**
     * @return JsonResponse
     */
    public function reject(): JsonResponse
    {
        $id = \request("id", 0);

        $data = CommissionLists::find($id);

        if ($data->status != 1) {

            return $this->error("该状态下无法执行操作");
        }
        $data->status = 2;

        $data->save();

        return $this->success("拒绝成功");
    }

    /**
     * @return JsonResponse
     */
    public function agree(): JsonResponse
    {
        $id = \request("id", 0);

        try {

            DB::beginTransaction();


            $data = CommissionLists::find($id);

            if ($data->status != 1) {

                throw new \Exception("该状态下无法执行操作");
            }
            $data->status = 3;

            $data->save();

            $ac = ChangeAccount::getAccountForLock($data->currency_id,$data->from_user_id);

            $ac->changeBalance(AccountLog::COMMISSION_AMOUNT,$data->exc_amount);
            DB::commit();
            return $this->success("已返佣");
        } catch (\Exception $e) {

            DB::rollBack();
            return $this->success($e->getMessage());
        }



    }
}
