<?php


namespace App\Notify\Email;

use App\Models\Setting\Setting;
use App\Models\User\User;
use App\Notify\Email;
use App\Notify\Notify;
use App\Exceptions\ThrowException;
use Illuminate\Support\Facades\Mail;

class SmtpEmail extends Notify
{

    public function config()
    {
        $this->send_type = self::EMAIL_DRIVER;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ThrowException
     */
    public function send()
    {
        Mail::to($this->to)->send($this->template);
    }

}
