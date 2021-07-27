<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;

class UserFcmTokenController extends Controller
{
    /**
     * Functionality to send notification.
     *
     */
    public function sendNotification($tokens, $body, $title, $subTitle)
    {
        $responseData = [];
        $FCM_SERVER_KEY = 'AAAAAzon57s:APA91bFZ1DAG2p8pp0OZARP7Y_sYs0VLOmgxOPpijYgCAUYbwf5hRXMDngz6vQa_QMleVI2Q8-C-_iZpbIbLgcYstlu02JOpRaY3dElxcyGZyzgtvEyhQLapKeEKAHw2bJ06OlSxTYfN';
        $msg = array(
            'body' => $body,
            'title' => $title,
            'subtitle' => $subTitle,
            'sound' => 'default',
        );
        $fields = array(
            'registration_ids' => $tokens,
            'notification' => $msg,
            'data' => [
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ],
            "android" => [
                'priority' => 'high',
                "notification" => [
                    "sound" => "default"
                ]
            ],
            "apns" => [
                "payload" => [
                    "sound" => "default"
                ]
            ]
        );
        $headers = array(
            'Authorization: key=' . $FCM_SERVER_KEY,
            'Content-Type: application/json',
            "apns-topic: io.flutter.plugins.firebase.messaging",
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            //die('FCM Send Error: ' . curl_error($ch));
            return false;
        }
        $result = json_decode($result, true);
        $responseData['android'] = [
            "result" => $result
        ];
        curl_close($ch);
        // return true;
        return $result;
    }
}
