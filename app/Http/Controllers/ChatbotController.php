<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamResult;
use App\Models\Attendance;
use App\Models\Fee;
use App\Models\Assignment;

class ChatbotController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Pokea data kutoka WhatsApp (ukichakata requests za JSON)
        $data = $request->all();

        // Extract ujumbe na namba ya mtumiaji
        $message = $data['message'] ?? 'Hakuna ujumbe';
        $from = $data['from'] ?? 'Hakuna namba';

        // Chambua ujumbe wa mtumiaji
        $response = $this->processMessage($message);

        // Tuma jibu kwa mtumiaji
        return response()->json(['reply' => $response]);
    }

    public function handleMessage(Request $request)
    {
        $text = $request->input('text');
        $sender = $request->input('sender');

        // Mfano wa kuchakata ujumbe
        $reply = match (strtolower($text)) {
            'hello' => 'Habari! Karibu kwenye mfumo wetu wa shule.',
            'results' => 'Tafadhali ingiza namba yako ya mwanafunzi.',
            default => 'Samahani, siwezi kuelewa ombi lako.',
        };

        return response()->json(['reply' => $reply]);
    }

    private function processMessage($message)
    {
        if (str_contains($message, 'matokeo')) {
            return $this->getResults(explode(' ', $message)[1] ?? null);
        } elseif (str_contains($message, 'mahudhurio')) {
            return $this->getAttendance(explode(' ', $message)[1] ?? null);
        } elseif (str_contains($message, 'ada')) {
            return $this->getFees(explode(' ', $message)[1] ?? null);
        } elseif (str_contains($message, 'kazi')) {
            return $this->getAssignments();
        }

        return "Samahani, siwezi kuelewa ombi lako. Tafadhali tuma ujumbe kama 'matokeo 1234' au 'mahudhurio 1234'.";
    }

    private function getResults($studentId)
    {
        if (!$studentId) return "Tafadhali taja ID ya mwanafunzi.";

        $results = ExamResult::where('student_id', $studentId)->get();
        if ($results->isEmpty()) {
            return "Hakuna matokeo yaliyopatikana kwa ID: $studentId.";
        }

        $output = "Matokeo ya mwanafunzi $studentId:\n";
        foreach ($results as $result) {
            $output .= "{$result->subject}: {$result->marks}\n";
        }
        return $output;
    }

    private function getAttendance($studentId)
    {
        if (!$studentId) return "Tafadhali taja ID ya mwanafunzi.";

        $attendance = Attendance::where('student_id', $studentId)->first();
        if (!$attendance) {
            return "Hakuna taarifa za mahudhurio kwa ID: $studentId.";
        }

        return "Mahudhurio ya mwanafunzi $studentId: {$attendance->present_days}/{$attendance->total_days} siku.";
    }

    private function getFees($studentId)
    {
        if (!$studentId) return "Tafadhali taja ID ya mwanafunzi.";

        $fees = Fee::where('student_id', $studentId)->first();
        if (!$fees) {
            return "Hakuna taarifa za ada kwa ID: $studentId.";
        }

        return "Ada iliyolipwa: {$fees->paid} / {$fees->total}.";
    }

    private function getAssignments()
    {
        $assignments = Assignment::all();
        if ($assignments->isEmpty()) {
            return "Hakuna kazi za nyumbani kwa sasa.";
        }

        $output = "Kazi za nyumbani:\n";
        foreach ($assignments as $assignment) {
            $output .= "{$assignment->name} (Deadline: {$assignment->deadline})\n";
        }
        return $output;
    }
}
