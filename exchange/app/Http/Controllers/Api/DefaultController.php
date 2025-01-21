<?php


namespace App\Http\Controllers\Api;

use App\BlockChain\BlockChain;
use App\Logic\UDunClound;
use App\Models\AppSetting\AppVersion;
use App\Models\Chain\ChainWallet;
use App\Models\Currency\Currency;
use App\Models\System\Lang;
use App\Models\User\Token;
use App\Models\User\User;
use App\Uploader\Local;
use App\Uploader\Uploader;
use Illuminate\Http\Request;
use App\Models\System\Area;
use App\Models\Setting\Setting;
use Artisan;

class DefaultController extends Controller
{

    /**
     * Tcpake app域名切换
     */
    public function app_switch()
    {
        return json_encode(['code' => 1, 'nameFile' => 'https://m.avmgcapi.com']);
    }

    /**
     * St5 app域名切换
     */
    public function st5_app()
    {
        return json_encode(['code' => 1, 'nameFile' => 'https://m.st5s.com']);
    }


    /**
     * Xt5 app域名切换
     */
    public function xt6_app()
    {
        return json_encode(['code' => 1, 'nameFile' => 'https://m.xt6td.com']);
    }

    /**
     * tradest5 app域名切换
     */
    public function tradest5_app()
    {
        return json_encode(['display' => true, 'url' => 'https://m.tradest5.com']);
    }

    /**
     * tt5 app域名切换
     */
    public function tt5_app()
    {
        return json_encode(['code' => 1, 'nameFile' => 'https://m.st5s.com']);
    }

    public function test()
    {
//        $body      = json_encode([
//            'address' => '1JQdH7gDBTzwgv5DYeqFdZByUkJ5vZMnbB',
//            'amount' => BlockChain::convertUpper(10.00000000,8),
//            'blockHigh' => '102419',
//            'coinType' => '0',
//            'decimals' => '8',
//            'fee' => '454124',
//            'mainCoinType' => '0',
//            'status' => 3, // 0待审核 1审核成功 2审核驳回 3交易成功 4交易失败
//            'tradeId' => '20181024175416907',
//            'tradeType' => 1,
//            'txid' => '31689c332536b56a2223232347e206fbed2d04d461a3d668c4c1de32a75a8d436f0',
//            'businessId' =>'',
//            'memo' =>'',
//        ]);
//        $timestamp = '1598342664';
//        $nonce     = '518437';
//        $key = 'a8a521e3667c862b33537919e83c674a';
//        $sign = md5($body . $key . $nonce . $timestamp);
//
//
//        $call_back_data = array(
//            'timestamp' => $timestamp,
//            'nonce'     => $nonce,
//            'sign'      => (string)$sign,
//            'body'      => $body,
//        );
//        var_dump($call_back_data);
        $user = User::find(84);
        BlockChain::generateAllOnlineWallet($user);



//        $level = request('level', -1);
//        $str   = gzencode('123456', $level);
//        // $str = gzcompress('123456');
//        // header("Content-Type: text/plain");
        ob_start();
//        Artisan::call('common:test');
        ob_end_clean();
        return $this->success('ok');
        // echo base64_encode($str);
    }

    // 获取国家
    public function areaList(Request $request)
    {

        $list = Area::with('lang')->orderBy('sort', 'asc')->orderBy('id', 'asc')->get();
        return $this->success("", $list);
    }

    // 获取语言
    public function langList()
    {
        $list = Lang::where('status', 1)
            ->orderBy('sort', 'asc')
            ->orderBy('id', 'asc')->get();
        return $this->success("", $list);
    }

    // 上传图片
    public function imageUpload(Request $request)
    {
        try {
            $file = request()->file('file');

            $msg = Uploader::newInstance(Local::class)->upload($file);
            return $this->success(__('upload.Upload Success'), $msg);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    // 获取设置
    public function setting()
    {
        $key   = request('key', '');
        $value = Setting::getValueByKey($key, '', true);
        return $this->success(__('api.请求成功'), $value);
    }

    public function checkUpdate()
    {
        $version_number = request('version_number');
        $type           = request('type');
        $os             = $type == 1 ? 'Android' : 'Ios';
        if (is_null($type) || is_null($version_number)) {
            return $this->error(__('api.参数异常'));
        }
        $new_version = AppVersion::where('type', $type)
            ->orderBy('created_at', 'DESC')
            ->first();
        if (is_null($new_version)) {
            return $this->error(__('api.版本异常'));
        }
        $whether = version_compare($version_number, $new_version->version_number, '>=');
        if ($whether) {
            return $this->error(__('api.您的APP不需要更新'));
        }
        $main_version     = substr($version_number, 0, strpos($version_number, '.'));
        $new_main_version = substr($new_version->version_number, 0, strpos($new_version->version_number, '.'));
        $wgt_url          = $new_version->wgt_url;
        $pkg_url          = $new_version->pkg_url;
        if ($new_main_version > $main_version) {
            $wgt_url = '';
        } else {
            $pkg_url = '';
        }
        return $this->success("$os" . __('api.发现新版本'), [
            'pkg_url'      => $pkg_url,
            'wgt_url'      => $wgt_url,
            'download_url' => config('app.url') . $new_version->download_url,
            'update'       => true,
        ]);
    }

    public function getAppVersionUrls()
    {

        return $this->success(__('api.请求成功'), AppVersion::all());
    }

    public function check_login()
    {
        //检查登陆状态
        $token = Token::getToken();
        $user_id = Token::getUserIdByToken($token);
        if (empty($user_id)) {
            return response()->json([
                'code' => '1',
                'data'=>[
                    "status"=>0
                ]
            ]);
        }
        return response()->json([
            'code' => '1',
            'data'=>[
                "status"=>1
            ]
        ]);
    }
}
