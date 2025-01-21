<?php


namespace App\Http\Controllers\Api;


use App\Models\Chain\ChainWallet;
use App\Models\QuickCharge\QuickCharge;
use App\Models\QuickCharge\QuickChargeOrder;
use App\Models\User\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\QuickCharge\QuickSymbol;
use App\Models\QuickCharge\WireSet;

class QuickChargeController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function info(request $request): JsonResponse
    {

        $res = QuickCharge::with('currency')
            ->with('currencyProtocol')
            ->orderBy('id', 'desc')
            ->get();
//        $uid = User::getUserId();
//        $res = ChainWallet::where("user_id",$uid)
//            ->with('currency')
//            ->with('currencyProtocol')
//            ->with('chainProtocol')
//            ->orderBy('id', 'desc')
//            ->get();

        $res->each(function ($item) {
            $item->append("currency_code");
            $item->append("currency_code_protocol");
        });
        return $this->success(__('api.请求成功'), $res);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function submit(request $request): JsonResponse
    {
        try {
            $number = $request->input("number", 0);
            $chargeId = $request->input("charge_id", 0);
            $proofImg = $request->input("proofImg", "");
            $address = $request->input("address", "");

            $QC = QuickCharge::where("id", $chargeId)->first();

            if (!$QC) {

                throw new Exception(__("api.找不到账户"));
            }


            if (empty($number) || empty($proofImg)) {
                throw new Exception(__("api.缺少参数或传值错误"));
            }
            $data = [
                'uid' => User::getUserId(),
                'number' => $number,
                'proof_img' => $proofImg,
                'address' => $address,
                'charge_id' => $chargeId,
                'created_at' => date("Y-m-d H:i:s"),
                'currency_id' => $QC->currency_id
            ];
            $res = QuickChargeOrder::insert($data);
            return $this->success(__('api.操作成功'), $res);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());
        }

    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function wire_submit(request $request): JsonResponse
    {
        try {
            $number = $request->input("number", 0);
            $proofImg = $request->input("proofImg", "");
            $wire_id = $request->input("wire_id", 0);


            $user_id = User::getUserId();

            if (empty($number) || empty($proofImg) || empty($wire_id)) {
                throw new Exception(__("api.缺少参数或传值错误"));
            }
            $data = [
                'uid' => $user_id,
                'number' => $number,
                'proof_img' => $proofImg,
                'wire_id' => $wire_id,
                'type' => 1,
                'created_at' => date("Y-m-d H:i:s"),
            ];
            $res = QuickChargeOrder::insert($data);
            return $this->success(__('api.操作成功'), $res);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function wire_info(request $request): JsonResponse
    {
        $bank_coin = $request->input("bank_coin");
        $res = WireSet::where("bank_coin",$bank_coin)->where("is_show",1)->get();

        return $this->success(__('api.操作成功'), $res);
    }

    /**
     * @return JsonResponse
     */
    public function symbols(): JsonResponse
    {

        return $this->success(__('api.操作成功'), QuickSymbol::get());
    }


    //充值列表
    public function quick_ist(request $request): JsonResponse
    {
        $limit = request('limit', 15);
        $uid = User::getUserId();
        $quick = QuickChargeOrder::with('currency')->where('uid',$uid)->orderBy('id', 'desc')
            ->paginate($limit);
        return $this->success(__('api.请求成功'), $quick);
    }
}
