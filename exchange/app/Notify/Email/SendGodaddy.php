<?php


namespace App\Notify\Email;

use App\Exceptions\ThrowException;
use App\Models\Setting\Setting;
use App\Notify\Notify;
use App\Notify\NotifyTemplate;

class SendGodaddy extends Notify
{
    public function config()
    {
        $this->send_type = self::EMAIL_DRIVER;
        $this->config['godaddy_host'] = Setting::getValueByKey('godaddy_host');
        $this->config['godaddy_hostname'] = Setting::getValueByKey('godaddy_hostname');
        $this->config['godaddy_username'] = Setting::getValueByKey('godaddy_username');
        $this->config['godaddy_password'] = Setting::getValueByKey('godaddy_password');
        $this->config['godaddy_from'] = Setting::getValueByKey('godaddy_from');
    }

    public function send()
    {

        $mail = new Godaddy\PHPMailer(true);

        $mail->IsSMTP();#stmp 使用smtp鉴权方式发送邮件
//        $mail->SMTPDebug = 1;
        $mail->CharSet = 'UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
        $mail->SMTPAuth = true; //开启认证

        $mail->SMTPSecure = 'ssl'; # 设置使用ssl加密方式登录鉴权
#$mail->Port = 25;#  //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
        $mail->Port = 465;
        $mail->Host = $this->config['godaddy_host'];
        $mail->Hostname = $this->config['godaddy_hostname'];#设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
        $mail->Username = $this->config['godaddy_username'];#邮箱账号
        $mail->Password = $this->config['godaddy_password'];#STMP授权码
        $mail->From = $this->config['godaddy_from'];
        $mail->FromName = $this->config['godaddy_username'];

        $mail->AddAddress($this->to); #抄送


        $mail->Subject = $this->config['godaddy_hostname'];
        $content = NotifyTemplate::strReplace($this->template->template_id, $this->buildVars());
//添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
        $mail->Body = $content;

//为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
//$mail->addAttachment('./1.png,'图片');
//同样该方法可以多次调用 上传多个附件
//$mail->addAttachment('./test.php','php文件');

        $mail->IsHTML(true);
        $ret = $mail->Send();

        if (!$ret) {

            throw new ThrowException('发送失败');
        }

    }

    public function buildVars()
    {
        $var = $this->template->content;
        return $var;
    }
}
