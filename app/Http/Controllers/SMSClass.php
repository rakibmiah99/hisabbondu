<?php


namespace App\Http\Controllers;
use App\Models\SettingsModel;

class SMSClass
{
   static function CreateSMS( $mobile,$SMSContent){
        $settings=SettingsModel::all('ssl_wireless_sms_api_token', 'ssl_wireless_sms_sid', 'ssl_wireless_sms_domain');
        $ssl_wireless_sms_api_token=$settings[0]['ssl_wireless_sms_api_token'];
        $ssl_wireless_sms_sid=$settings[0]['ssl_wireless_sms_sid'];
        $ssl_wireless_sms_domain=$settings[0]['ssl_wireless_sms_domain'];
        $API_TOKEN =  $ssl_wireless_sms_api_token;
        $SID = $ssl_wireless_sms_sid;
        $DOMAIN = $ssl_wireless_sms_domain;
        $randomTimeStamp=time();
        $smsBody=$SMSContent;
        $msisdn = $mobile;
        $messageBody = $smsBody;
        $csmsId = $randomTimeStamp;
        $params = [
            "api_token" =>  $API_TOKEN,
            "sid" => $SID,
            "msisdn" => $msisdn,
            "sms" => $messageBody,
            "csms_id" => $csmsId
        ];

        $url = trim($DOMAIN, '/')."/api/v3/send-sms";
        $params = json_encode($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'accept:application/json'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $status=(json_decode($response,true))['status'];

        if($status=="SUCCESS"){
            return  1;
        }
        else{
            return  0;
        }
    }
}
