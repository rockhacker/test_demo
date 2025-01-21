<?php


namespace App\Notify;

use App\Jobs\SendNotify;
use App\Models\System\Area;
use App\Models\User\NotifyLog;
use App\Notify\Email\SendCloudEmail;
use App\Notify\Email\SendGodaddy;
use App\Notify\Email\Template\EmailAdminLoginCode;
use App\Notify\Email\Template\EmailChangePayPasswordCode;
use App\Notify\Email\Template\EmailFindPasswordCode;
use App\Notify\Email\Template\EmailLoginCode;
use App\Notify\Email\Template\EmailRegisterCode;
use App\Notify\Email\Template\EmailTest;
use App\Notify\Email\Template\EmailWithdrawCode;
use App\Notify\SMS\SendCloundSMS;
use App\Notify\SMS\Template\SMSAdminLoginCode;
use App\Notify\SMS\Template\SMSChangePayPasswordCode;
use App\Notify\SMS\Template\SMSFindPasswordCode;
use App\Notify\SMS\Template\SMSLoginCode;
use App\Notify\SMS\Template\SMSRegisterCode;
use App\Notify\SMS\Template\SMSTest;
use App\Notify\SMS\Template\SMSWithdrawCode;
use App\Exceptions\ThrowException;
use App\Notify\Email\ModuyunEmail;
use App\Notify\Email\SmtpEmail;
use App\Notify\SMS\ModuyunSMS;

/**通知驱动父类
 * Class SendNotify
 *
 * @package App\SendNotify
 */
abstract class Notify
{
    //默认驱动
    const SMS = SendCloundSMS::class;
    const EMAIL = SendGodaddy::class;

    const MODUYUNEMAIL = ModuyunEmail::class;


    //当前驱动类型
    protected $send_type;
    //驱动类型
    const SMS_DRIVER = 'SMS';
    const EMAIL_DRIVER = 'EMAIL';

    //短信类型
    const REGISTER = [1, '注册', [
        self::SMS_DRIVER => SMSRegisterCode::class,
        self::EMAIL_DRIVER => EmailRegisterCode::class,
    ]];
    const FIND_PASSWORD = [2, '找回密码', [
        self::SMS_DRIVER => SMSFindPasswordCode::class,
        self::EMAIL_DRIVER => EmailFindPasswordCode::class,
    ]];
    const CHANGE_PAY_PASSWORD = [3, '修改支付密码', [
        self::SMS_DRIVER => SMSChangePayPasswordCode::class,
        self::EMAIL_DRIVER => EmailChangePayPasswordCode::class,
    ]];
    const WITHDRAW = [4, '提币', [
        self::SMS_DRIVER => SMSWithdrawCode::class,
        self::EMAIL_DRIVER => EmailWithdrawCode::class,
    ]];
    const LOGIN = [5, '登陆', [
        self::SMS_DRIVER => SMSLoginCode::class,
        self::EMAIL_DRIVER => EmailLoginCode::class,
    ]];
    const TEST = [6, '测试', [
        self::SMS_DRIVER => SMSTest::class,
        self::EMAIL_DRIVER => EmailTest::class,
    ]];
    const ADMIN_LOGIN = [7, '管理员登陆', [
        self::SMS_DRIVER => SMSAdminLoginCode::class,
        self::EMAIL_DRIVER => EmailAdminLoginCode::class,
    ]];
    //场景
    const SCENES = [
        self::REGISTER[0] => self::REGISTER,
        self::FIND_PASSWORD[0] => self::FIND_PASSWORD,
        self::CHANGE_PAY_PASSWORD[0] => self::CHANGE_PAY_PASSWORD,
        self::WITHDRAW[0] => self::WITHDRAW,
        self::LOGIN[0] => self::LOGIN,
        self::TEST[0] => self::TEST,
        self::ADMIN_LOGIN[0] => self::ADMIN_LOGIN,
    ];


    //过期时间(秒)
    const TIMEOUT = 600;
    //重复发送时间(秒)
    const RESEND = 60;

    /**
     * 模板
     *
     * @var NotifyTemplate
     */
    public $template;

    /**配置
     *
     * @var array
     */
    public $config = [];

    /**发送目标
     *
     * @var string
     */
    public $to;

    /**国家代码
     *
     * @var Area
     */
    public $area;

    /**场景
     *
     * @var array
     */
    public $scene;

    public function __construct($to, $area)
    {
        $this->to = $to;
        $this->area = $area;
        $this->config();
    }

    protected abstract function config();

    /**发送验证码
     *
     * @throws \Exception
     */
    public abstract function send();

    /**异步发送
     *
     * @return Notify
     *
     */
    public function asyncSend()
    {
        SendNotify::dispatch($this);
        return $this;
    }

    /**
     * @param $class
     * @param $to
     * @param string $area
     * @return $this
     */
    public static function newInstance($class, $to, $area = "")
    {
        $instance = new $class($to, $area);
        return $instance;
    }

    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    /**设置发送的模板
     *
     * @param       $scene
     * @param array $params
     *
     * @return Notify
     * @throws \Exception
     */
    public function template($scene, $params = [])
    {
        $template = $scene[2][$this->send_type] ?? null;
        if (!$template) {
            throw new ThrowException('通知模板不存在');
        }
        //模板载入配置
        $this->scene = $scene;
        $this->template = new $template($this,$params);
        return $this;
    }

    /**
     * 记住短信内容
     *
     * @return $this
     * @throws \Exception
     */
    public function remember()
    {
        if (!$this->template) {
            throw new ThrowException('先设置模板,再记住通知内容');
        }
        NotifyLog::create([
            'to' => $this->to,
            'content' => $this->template->content,
            'type' => $this->scene[0],
        ]);
        return $this;
    }

    /**
     * 检查验证码
     *
     * @param $to
     * @param $scene
     * @param $code
     *
     * @return bool
     */
    public static function checkCode($to, $scene, $code)
    {

        $notify = NotifyLog::where('to', $to)->where('type', $scene[0])
            ->where('created_at', '>', now()->subSeconds(self::TIMEOUT))
            ->orderBy('id', 'DESC')->first();

        if (!$notify) {
            return false;
        }
        $database_code = $notify->content['code'] ?? '';
        if ($database_code != $code) {
            return false;
        }
        //验证成功删除验证码
//        $notify->delete();
        return true;
    }

}
