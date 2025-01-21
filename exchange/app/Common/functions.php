<?php


//if (!function_exists('exception')) {
//    /**抛一个异常
//     *
//     * @param      $message
//     * @param int  $code
//     * @param null $previous
//     *
//     * @throws Exception
//     */
//    function exception($message, $code = 0, $previous = null)
//    {
//        $e = new App\Exceptions\ThrowException($message, $code, $previous);
//        throw $e;
//    }
//}

if (!function_exists('parse_price')) {
    /**转换价格的小数位
     *
     */
    function parse_price($price, $currencyMatch = null, $set_decimal = null)
    {
        $model_decimal = $currencyMatch->price_decimal ?? null;
        $decimal = $set_decimal ?? $model_decimal;
        if ($decimal) {
            return bc($price, '+', 0, $decimal);
        }
        if ($price <= 0) {
            return bc(0, '+', 0, 0);
        }
        if ($price >= 10) {
            return bc($price, '+', 0, 2);
        }
        if ($price >= 1) {
            return bc($price, '+', 0, 4);
        }
        if ($price >= 0.01) {
            return bc($price, '+', 0, 6);
        }
        return bc($price, '+', 0, 8);
    }
}

if (!function_exists('parse_number')) {
    /**转换数量的小数位
     *
     */
    function parse_number($price, $number, $currencyMatch = null, $set_decimal = null)
    {
        $model_decimal = $currencyMatch->price_decimal ?? null;
        $decimal = $set_decimal ?? $model_decimal;
        if ($decimal) {
            return bc($number, '+', 0, $decimal);
        }
        if ($price <= 0) {
            return bc($number, '+', 0, 8);
        }
        if ($price > 1000) {
            return bc($number, '+', 0, 6);
        }
        if ($price > 1) {
            return bc($number, '+', 0, 4);
        }
        return bc($number, '+', 0, 2);
    }
}


/**
 * 打印输出
 *
 * @param $info
 *
 * @return string
 */
function print_info($info)
{
    echo $info . PHP_EOL;
}

/**
 * 科学计数法转字符串
 *
 * @param float   $num 数值
 * @param integer $double
 *
 * @return string
 */
function sctonum($num, $double = DECIMAL_SCALE)
{
    return \App\Utils\BC::sctonum($num, $double);
}

if (!function_exists('http')) {
    /**
     * @param        $url
     * @param null   $data
     * @param string $method
     * @param array  $headers
     *
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function http($url, $data = null, $method = 'GET', $headers = [])
    {
        $query = strtoupper($method) == 'GET' ? $data : null;
        $form_params = strtoupper($method) == 'POST' ? $data : null;

        $client = new GuzzleHttp\Client();
        $response = $client->request($method, $url, [
            'query' => $query,
            'form_params' => $form_params,
            'headers' => $headers,
            'verify' => false,
        ])->getBody()->getContents();

        return json_decode($response, true) ?? [];
    }
}


if (!function_exists('raw_http')) {
    /**
     * @param        $url
     * @param mixed $body
     * @param array $query
     * @param array $headers
     *
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function raw_http($url, $body, $query, $headers = [])
    {
        $client = new GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'verify' => false,
            'body' => $body,
            'query' => $query,
        ])->getBody()->getContents();

        return json_decode($response, true) ?? [];
    }
}

if (!function_exists('transaction')) {
    /**开启事务,只能在控制器中使用
     * 因为处理异常的返回类型是response
     *
     * @param callable $callback
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ThrowException
     */
    function transaction(callable $callback)
    {
        try {
            return \Illuminate\Support\Facades\DB::transaction($callback);
        } catch (\App\Exceptions\ThrowException $e) {
            throw $e;
        } catch (\Throwable $t) {
            $e = new \App\Exceptions\ThrowException();
            $e->setMessage($t->getMessage());
            $e->setFile($t->getFile());
            $e->setLine($t->getLine());
            throw $e;
        }
    }

}

if (!function_exists('bc')) {

    function bc($num1, $symbol, $num2, $decimals = null)
    {
        return \App\Utils\BC::compute($num1, $symbol, $num2, $decimals);
    }
}

if (!function_exists('rest_rule')) {
    function rest_rule($controller, $name = '')
    {
        if (!$name) {
            $route = \Illuminate\Support\Facades\Route::group([], function () use ($controller, $name) {
                \Illuminate\Support\Facades\Route::get('/index', "{$controller}@index");
                \Illuminate\Support\Facades\Route::get('/list', "{$controller}@list");
                \Illuminate\Support\Facades\Route::get('/add', "{$controller}@add");
                \Illuminate\Support\Facades\Route::post('/save', "{$controller}@save");
                \Illuminate\Support\Facades\Route::get('/edit', "{$controller}@edit");
                \Illuminate\Support\Facades\Route::post('/update', "{$controller}@update");
                \Illuminate\Support\Facades\Route::get('/delete', "{$controller}@delete");
                \Illuminate\Support\Facades\Route::get('/detail', "{$controller}@detail");
            });
            return $route;
        }

        $route = \Illuminate\Support\Facades\Route::group([], function () use ($controller, $name) {
            if (method_exists("App\Http\Controllers\Admin\\{$controller}", 'index')) {
                \Illuminate\Support\Facades\Route::get('/index', "{$controller}@index")->name("{$name}页面");
            }
            if (method_exists("App\Http\Controllers\Admin\\{$controller}", 'list')) {
                \Illuminate\Support\Facades\Route::get('/list', "{$controller}@list")->name("{$name}列表");
            }
            if (method_exists("App\Http\Controllers\Admin\\{$controller}", 'add')) {
                \Illuminate\Support\Facades\Route::get('/add', "{$controller}@add")->name("增加{$name}");
            }
            if (method_exists("App\Http\Controllers\Admin\\{$controller}", 'save')) {
                \Illuminate\Support\Facades\Route::post('/save', "{$controller}@save")->name("保存{$name}");
            }
            if (method_exists("App\Http\Controllers\Admin\\{$controller}", 'edit')) {
                \Illuminate\Support\Facades\Route::get('/edit', "{$controller}@edit")->name("编辑{$name}");
            }
            if (method_exists("App\Http\Controllers\Admin\\{$controller}", 'update')) {
                \Illuminate\Support\Facades\Route::post('/update', "{$controller}@update")->name("更新{$name}");
            }
            if (method_exists("App\Http\Controllers\Admin\\{$controller}", 'delete')) {
                \Illuminate\Support\Facades\Route::get('/delete', "{$controller}@delete")->name("删除{$name}");
            }
            if (method_exists("App\Http\Controllers\Admin\\{$controller}", 'detail')) {
                \Illuminate\Support\Facades\Route::get('/detail', "{$controller}@detail")->name("{$name}详情");
            }
        });
        return $route;
    }
}

if (!function_exists('is_json')) {
    function is_json($data = '', $assoc = false)
    {
        $data = json_decode($data, $assoc);
        if ($data && (is_object($data)) || (is_array($data) && !empty(current($data)))) {
            return true;
        }
        return false;
    }
}


if (!function_exists('json_response_error')) {
    /**发送json错误
     *
     * @param $msg
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function json_response_error($msg, $data = [])
    {
        return response()->json([
            'code' => 0,
            'msg' => $msg,
            'data' => $data,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}


if (!function_exists('json_response_success')) {
    /**发送json数据
     *
     * @param $msg
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function json_response_success($msg, $data = [])
    {
        return response()->json([
            'code' => 1,
            'msg' => $msg,
            'data' => $data,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
if (!function_exists('active_rate')) {
    /**
     * @param $type
     * @param $symbol
     * @return int|mixed
     */
    function active_rate($type,$symbol){
        $url = "https://api.exchangerate-api.com/v4/latest/USD";
        /*
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $res = json_decode(curl_exec($ch),true);
        curl_close($ch);
        */
        $stream_opts = [
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ];
        $ch = file_get_contents($url,false, stream_context_create($stream_opts));
        //var_dump($ch);
        $res = json_decode($ch,true);
        if(!isset($res['base']) || $res['base'] != "USD")return 0;
        if(!isset($res['rates']))return 0;
        $huilv = 0;
        foreach($res['rates'] as $k => $v){
            if($symbol){
                if($symbol == $k){
                    $huilv = $v;
                }
            }
        }
        return $huilv;
    }
}
if (!function_exists('active_rate_symbol')) {

    function active_rate_symbol()
    {
        return [
            'USD',
            'CNY',
            'TWD',
            'HKD',
            'EUR',
            'CAD',
            'MYR',
            'THB',
            'KRW',
            'JPY',
            'GBP',
        ];
    }
}

if(!function_exists('redisLockWait')){
    /**
     * redis锁
     * @param $attr_key
     * @param $key
     * @param $callable
     * @param int $msleep 等待锁毫秒数
     * @return mixed
     * @throws \Exception
     * @author: fz
     * @date: 2021/12/17 18:56
     */
    function redisLockWait($redis_key,$callable,$expire = 10 ,$msleep=100){
        $redis = app('redis')->connection();
        $start_time = time();
        do{
            $res = $redis->setnx($redis_key,1);
            if($res){
                $redis->expire($redis_key,$expire);
                $value = $callable();
                $redis->del($redis_key);
                return $value;
            }
            usleep($msleep*1000);     //等待
            $t = time() - $start_time;
        }while($t<$expire);
        throw new \Exception('锁等待超时');
    }
}


