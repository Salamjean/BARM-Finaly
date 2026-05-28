<?php

namespace App\Repositories;

use GuzzleHttp\Client;


class SmsRepository
{
    public function __construct($phone, $message)
    {
        $this->phone = $phone;
        $this->message = $message;
    }

    protected $message;
    protected $phone;
    protected $headers = [
        'Cookie' => 'PHPSESSID=hodjov6cacnt3akre24fkhbj62',
    ];

    public function send(){
        $url = "https://panel.smsing.app/smsAPI?sendsms&apikey=s5KE7XLhUg2oCfnjCt7puvata7HXusun&apitoken=A7HI1698424319&type=sms&from=OTP&to=+225$this->phone&text=$this->message";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

}
