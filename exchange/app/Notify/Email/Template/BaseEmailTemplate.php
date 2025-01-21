<?php


namespace App\Notify\Email\Template;

use App\Models\Setting\Setting;
use App\Notify\NotifyTemplate;
use App\Notify\Notify;

/**基本模板
 * Class BaseEmailTemplate
 *
 * @package App\Notify\SMS\Template
 */
abstract class BaseEmailTemplate extends NotifyTemplate
{

    public $baseTmp = "
                <p><strong>Hello!</strong></p>
                <p>Your verification code is @var(code) 。Please input the verification code in the verification code input box to complete the operation.</strong></p>
                <p>Please do not disclose the CAPTCHA to others. If it is not my operation, please ignore it.</p>
                <br />
                ";
    public $baseJpTmp = "
                <p><strong>親愛なるメンバー：こんにちは！</strong></p>
                <p>確認コードは @var(code) です。 確認コード入力ボックスに確認コードを入力して、操作を完了してください</strong></p>
                <p>確認コードを他人に開示しないでください。 自分の操作でない場合は無視してください。</p>
                <br />
                ";
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->content['scene'] = $this->notify->scene[1];
        return $this->from(config('mail.username'))->view("email.{$this->template_id}", $this->content);
    }


    public function LangeTmp(): string
    {
        $lang = request()->header("lang") ?? "en";

        switch ($lang){
            case "jp":
                return $this->baseJpTmp;

            default:
                return $this->baseTmp;
        }
    }

}
