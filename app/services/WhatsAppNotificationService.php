<?php

// WhatsAppNotificationService.php

namespace App\Services;

use App\Models\NotificationLog;
use App\Models\Student;
use App\Models\Students;
use App\Helpers\WhatsAppSender; // Class ya kutuma ujumbe WhatsApp

class WhatsAppNotificationService
{
    public function sendNotification($studentId, $examType, $month, $academicYear, $class)
    {
        $student = Students::find($studentId);
        $parentPhone = $student->parent_phone;

        // Check if already sent to avoid duplicate sending
        $alreadySent = NotificationLog::where([
            'student_id' => $studentId,
            'exam_type' => $examType,
            'month' => $month,
            'academic_year' => $academicYear,
            'sent' => true,
        ])->exists();

        if ($alreadySent) return; // If already sent, no need to send again

        // Construct message
        $message = "Habari! Matokeo ya mwanao (Jina: {$student->first_name} {$student->last_name}, Darasa: {$class}) ya mtihani wa {$examType}, {$month} {$academicYear} yako tayari.\n\n"
            . "Tafadhali angalia kupitia WhatsApp bot ya shule. Unaweza pia kuona taarifa nyingine kama:\n"
            . "- Ada\n- Mahudhurio\n- Assignment\n\n"
            . "👉 Jibu neno: *Matokeo* kupata matokeo.\n"
            . "👉 Jibu neno: *Ada* kuona hali ya malipo.\n"
            . "👉 Jibu neno: *Mahudhurio* kuona frekwensi ya mwanao.\n\n"
            . "Asante kwa kushirikiana na shule.";

        // Send WhatsApp message
        WhatsAppSender::sendMessage($parentPhone, $message);

        // Log notification to NotificationLog model
        NotificationLog::create([
            'student_id' => $studentId,
            'exam_type' => $examType,
            'month' => $month,
            'academic_year' => $academicYear,
            'sent' => true,
        ]);
    }
}
