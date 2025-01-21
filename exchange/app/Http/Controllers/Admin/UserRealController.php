<?php


namespace App\Http\Controllers\Admin;


use App\BlockChain\BlockChain;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyProtocol;
use App\Models\System\Area;
use App\Models\User\User;
use App\Models\User\UserReal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRealController extends Controller
{
    public function index()
    {
        return view('admin.userReal.index');
    }

    public function update(Request $request): JsonResponse
    {
        $id = $request->get("id", 0);
        $name = $request->get("name", "");
        $card_id = $request->get("card_id", '');
        $review_status = $request->get("review_status", 0);
        $remark = $request->get("remark", '');

        if (!$name) {

            return $this->error("名字必须填写");
        }
        if (!$card_id) {

            return $this->error("身份证必须填写");
        }

        if($review_status == UserReal::REJECT && empty($remark)){
            return $this->error('驳回理由必须填写');
        }

        $userreal_number = UserReal::where('card_id', $card_id)
            ->where("id", "!=", $id)
            ->count();
        if ($userreal_number > 0) {
            return $this->error("该身份证号已使用!");
        }

        UserReal::where("id",$id)->update([
            "name"=>$name,
            "card_id"=>$card_id,
            'review_status' => $review_status,
            'remark' => $remark
        ]);

        return $this->success("修改成功");
    }


    public function list(Request $request)
    {
        $limit = $request->get('limit', 10);
        $uid = $request->get('uid', '');
        $email = $request->get('email', '');
        $mobile = $request->get('mobile', '');

        $list = UserReal::with(['user'])->when($uid, function ($query, $uid) {
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
        })->orderBy('review_status')->orderByDesc('created_at')->paginate($limit);

        return $this->layuiPageData($list);
    }

    public function add()
    {

    }

    public function reviewStatus(Request $request)
    {
        $id = $request->get('id', 0);
        $userreal = UserReal::find($id);
        if (empty($userreal)) {
            return $this->error('参数错误');
        }
        if ($userreal->review_status == UserReal::REJECT) {
            $userreal->review_status = UserReal::CONFORM;
        } elseif ($userreal->review_status == UserReal::CONFORM) {
            $userreal->review_status = UserReal::REJECT;
        } else {
            $userreal->review_status = UserReal::REJECT;
        }
        try {

            if ($userreal->review_status == UserReal::CONFORM) {

                $pro = CurrencyProtocol::get();

                $user_id = $userreal->user_id;

                foreach ($pro as $k => $v) {

                    $currency = Currency::findOrFail($v->currency_id);

                    //循环创建去中心化钱包
//                    foreach ($currency->currencyProtocols()->cursor() as $currencyProtocol) {
//                        $blockChain = BlockChain::newInstance($currencyProtocol);
//
//                        DB::transaction(function () use ($blockChain, $user_id) {
//
//                            $user = User::find($user_id);
//
//                            $blockChain->generateOnlineWallet($user);
//
//                        });
//                    }
                }
//                $userreal->is_create_address = 1;
            }

            $userreal->save();
            return $this->success('操作成功');
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }


    public function createAddress()
    {

        try {
            $id = request()->input("id", 0);
            $userreal = UserReal::find($id);
            if (empty($userreal)) {
                return $this->error('参数错误');
            }
            $userreal->is_create_address = 1;


            $user_id = $userreal->user_id;

//            foreach (CurrencyProtocol::get() as $k => $v) {
//
//                $currency = Currency::findOrFail($v->currency_id);
//
//                //循环创建去中心化钱包
//                foreach ($currency->currencyProtocols()->cursor() as $currencyProtocol) {
//                    $blockChain = BlockChain::newInstance($currencyProtocol);
//
//                    DB::transaction(function () use ($blockChain, $user_id) {
//
//                        $user = User::find($user_id);
//
//                        $blockChain->createOrUpdateUserAddress($user);
//
//                    });
//                }
//            }
            $userreal->save();
            return $this->success('操作成功');
        } catch (\Exception $exception) {

            return $this->error($exception->getMessage());
        }

    }


    public function detail(Request $request)
    {
        $id = $request->get('id', 0);
        $user_real = UserReal::where('id', $id)->first();
        if (empty($user_real)) {
            return $this->error('参数错误');
        }
        return view('admin.userReal.detail', ['user_real' => $user_real]);
    }

    public function delete(Request $request)
    {
        $id = $request->get('id', 0);
        $user_real = UserReal::where('id', $id)->first();
        if (empty($user_real)) {
            return $this->error('参数错误');
        }
        try {
            $user_real->delete();
            return $this->success('操作成功');
        } catch (\Exception $e) {
            return $this->error('操作失败');
        }
    }
}
