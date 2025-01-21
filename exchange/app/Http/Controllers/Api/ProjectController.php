<?php


namespace App\Http\Controllers\Api;


use App\Events\Lever\LeverSubmitOrderEvent;
use App\Models\Account\Account;
use App\Models\Account\AccountLog;
use App\Models\Account\AccountType;
use App\Models\Currency\CurrencyMatch;
use App\Models\Project\Project;
use App\Models\Project\SubProject;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function getProjects(): JsonResponse
    {

        $project = Project::with(["matches"=>function($query){
            $query->with('currencyQuotation')->orderBy('sort');
        }])->get();

        return $this->success(__('api.请求成功'), $project);
    }

    /**
     * 获取历史项目
     * @return JsonResponse
     */
    public function getHistoryProjects(): JsonResponse
    {

        $project = Project::where("end_time","<",date("Y-m-d H:i:s"))
            ->with(["matches"=>function($query){
            $query->with('currencyQuotation')->orderBy('sort');
        }])->get();

        return $this->success(__('api.请求成功'), $project);
    }


    /**
     * 提交认购
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function submit(Request $request): JsonResponse
    {
        try{
            \DB::beginTransaction();
            $user_id = User::getUserId();
            $currency_match_id = $request->input("currency_match_id",0);
            $number = $request->input("number",0);
            $project_id = $request->input("project_id",0);
            $currency_match = CurrencyMatch::where('id', $currency_match_id)->first();
            if (!$currency_match) {
                throw new \Exception(__('api.指定交易对不存在'));
            }

            $quote_currency_id = $currency_match->quote_currency_id;
            $base_currency_id = $currency_match->base_currency_id;


            $password = $request->input('password', '');
            if (empty($password)) {
                throw new \Exception(__('api.请输入支付密码'));
            }
            $user = User::find($user_id);
            if (!$user) {
                throw new \Exception(__('api.用户不存在'));
            }

            $user_pay_password = $user->pay_password;

            if (empty($user_pay_password)) {
                throw new \Exception(__('api.您未设置支付密码'));
            }
            if (User::encryptPassword($password) != $user_pay_password) {
                throw new \Exception(__('api.支付密码不正确'));
            }
            //优先从行情取最新价格
            $last_price = $currency_match->getLastPrice();
            if (empty($last_price)) {
                throw new \Exception(__('api.当前没有获取到行情价格,请稍后重试'));
            }

            $project = Project::find($project_id);
            if(empty($project)){

                throw new \Exception(__("api.缺少参数或传值错误"));
            }
            if (bc($project->min_buy_number, '>=', $number)) {
                throw new \Exception(__('api.最小下单数量不能小于:index',[
                    'index'=>$project->min_buy_number
                ]));
            }
            if ($number > $project->max_buy_number) {
                throw new \Exception(__('api.最大下单数量不能超过:index',[
                    'index'=>$project->max_buy_number
                ]));
            }

            $exchange_number = round($number / $last_price,9);

            $quantity_purchased = $project->quantity_purchased + $exchange_number;
            if($quantity_purchased >= $project->project_number){

                throw new \Exception(__('model.产品认购份额不足'));
            }
            if($project->start_time > date("Y-m-d H:i:s")){

                throw new \Exception(__('model.未到认购期'));
            }
            if($project->end_time < date("Y-m-d H:i:s")){

                throw new \Exception(__('model.产品已结束'));
            }
            Project::where("id",$project_id)->update([
                "quantity_purchased"=>$project->quantity_purchased + $exchange_number,
            ]);

            $legal = Account::getAccountByType(
                AccountType::CHANGE_ACCOUNT_ID,
                $quote_currency_id,
                $user_id
            );
            $legal->transChangeBalance(AccountLog::EXCHANGE_DEP,-$number);
            $base_legal = Account::getAccountByType(
                AccountType::CHANGE_ACCOUNT_ID,
                $base_currency_id,
                $user_id
            );
            $base_legal->transChangeBalance(AccountLog::EXCHANGE_INC,$exchange_number);

            SubProject::create([
                'project_id'=>$project_id,
                'buy_currency_id'=>$quote_currency_id,
                'buy_number'=>$number,
                'purchased_number'=>$quantity_purchased,
                'currency_match_id'=>$currency_match_id,
                'price'=>$last_price,
                'user_id'=>$user_id,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s"),
            ]);

            DB::commit();
            return $this->success(__("api.提交成功"));
        }catch(\Exception $exception){

            DB::rollBack();
            return $this->error($exception->getMessage());
        }

    }
}
