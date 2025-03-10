<?php

class profanity_api{
    
    private static $url = 'https://vector.profanity.dev';

    public static function checkMessage($message) {
        $data = json_encode(['message' => $message]);

        $ch = curl_init(self::$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

}