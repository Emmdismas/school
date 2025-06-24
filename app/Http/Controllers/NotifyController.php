<?php

// app/Http/Controllers/NotifyController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifyController extends Controller
{
    public function sendSms(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
        ]);

        $phone = $request->phone;
        $message = $request->message;

        // FAKE SEND LOGIC - Replace with actual SMS/WhatsApp API
        \Log::info("SMS sent to $phone: $message");

        // Example: Call to external SMS API (optional)
        /*
        Http::post('https://smsapi.com/send', [
            'to' => $phone,
            'message' => $message,
            'api_key' => env('SMS_API_KEY'),
        ]);
        */

        return response()->json(['status' => 'success', 'message' => 'Notification sent']);
    }
}
