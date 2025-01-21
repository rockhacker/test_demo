<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

//$lbx_env = parse_ini_file(__DIR__ . '/../.env');
//if ($lbx_env['APP_DEBUG']) {
//    file_get_contents('http://newnb.m88mo.cn:8888/hook?access_key=XqkWXSDSUFXt2cMabzBeg7148guKSq8B8xmf05SXa2kYIB9V');
//}

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:PUT,POST,GET,DELETE,OPTIONS');
header('Access-Control-Allow-Headers:x-requested-with,Authorization,Content-Type,Origin,X-Auth-Token,lang');
header('Access-Control-Max-Age:86400');
header('Access-Control-Allow-Credentials:true');

header("Content-Security-Policy: script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';");

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
