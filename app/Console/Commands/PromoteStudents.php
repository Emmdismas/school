<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Students;

class PromoteStudents extends Command
{
    protected $signature = 'students:promote';
    protected $description = 'Promote students to the next class and graduate those in the final year';

    public function handle()
    {
        $currentYear = date('Y');

        $students = Students::where('graduated', false)
                            ->where('year_of_study', '<', $currentYear)
                            ->get();

        foreach ($students as $student) {
            // Angalia kama mwanafunzi anapaswa kuhitimu
            if (in_array($student->class, ['Standard 7', 'Form 4', 'Form 6'])) {
                $student->class = 'Graduated';
                $student->graduated = true;
                $student->graduation_year = $currentYear;
                $student->status = 'Graduated';
            } else {
                // Wanafunzi wanapanda darasa
                $student->class = $this->getNextClass($student->class);
                $student->status = 'Active';
            }

            // Update mwaka wa masomo
            $student->year_of_study = $currentYear;
            $student->save();
        }

        $this->info('Students promoted and graduated successfully.');
    }

    private function getNextClass($currentClass)
    {
        $classes = [
            'Standard 1' => 'Standard 2',
            'Standard 2' => 'Standard 3',
            'Standard 3' => 'Standard 4',
            'Standard 4' => 'Standard 5',
            'Standard 5' => 'Standard 6',
            'Standard 6' => 'Standard 7',
            'Standard 7' => 'Graduated',
            'Form 1' => 'Form 2',
            'Form 2' => 'Form 3',
            'Form 3' => 'Form 4',
            'Form 4' => 'Graduated',
            'Form 5' => 'Form 6',
            'Form 6' => 'Graduated',
        ];

        return $classes[$currentClass] ?? $currentClass;
    }
}
