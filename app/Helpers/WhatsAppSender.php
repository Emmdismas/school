<?php

namespace App\Helpers;


class WhatsAppSender
{
    public static function sendMessage($phoneNumber, $message)
    {
        // Hakikisha namba ni ya kimataifa mfano: 2557XXXXXX
        $formattedPhone = self::formatPhoneNumber($phoneNumber);

        // Tuma kupitia API (hapa mfano rahisi wa kutumia cURL)
        $url = 'https://your-whatsapp-api.com/send-message'; // Badilisha na API yako halisi

        $data = [
            'phone' => $formattedPhone,
            'message' => $message,
        ];

        $headers = [
            'Authorization: Bearer YOUR_API_TOKEN', // Badilisha token yako halisi
            'Content-Type: application/json',
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        // Unaweza kuchagua kurudi success au failure
        return $statusCode === 200;
    }

    private static function formatPhoneNumber($phone)
    {
        // Mfano: Convert 07xxxxxx to 2557xxxxxx
        $phone = trim($phone);
        if (str_starts_with($phone, '0')) {
            $phone = '255' . substr($phone, 1);
        }
        return $phone;
    }
}
