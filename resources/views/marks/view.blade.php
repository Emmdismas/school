<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks - School Management System</title>
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
</head>

<body>
<div class="container">
    <h2 class="text-center text-primary">Marks for {{ $class }}</h2>
    <h4 class="text-center text-secondary">Exam Type: <span class="text-info">{{ $examType }}</span></h4>

    <!-- Month & Year Selection -->
    <form method="GET" action="{{ route('marks.show', ['class' => $class, 'examType' => $examType]) }}" class="text-center mb-3">
        <label for="examType"><b>Select Exam Type:</b></label>
        <select name="examType" id="examType" required>
            @foreach (['Mock', 'Terminal', 'Midterm', 'Test'] as $exam)
                <option value="{{ $exam }}" {{ request('examType') == $exam ? 'selected' : '' }}>{{ $exam }}</option>
            @endforeach
        </select>
        <br><br>

        <label for="month"><b>Select Month:</b></label>
        <select name="month" id="month">
            <option value="">-- All Months --</option>
            @for ($m = 1; $m <= 12; $m++)
                @php $monthName = date('F', mktime(0, 0, 0, $m, 1)); @endphp
                <option value="{{ $monthName }}" {{ $selectedMonth == $monthName ? 'selected' : '' }}>
                    {{ $monthName }}
                </option>
            @endfor
        </select>
        <br><br>

        <label for="academic_year"><b>Academic Year:</b></label>
        <select name="academic_year" id="academic_year">
            @foreach (['2024/25', '2025/26', '2026/27', '2027/28', '2028/29', '2029/30'] as $year)
                <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Fetch Marks</button>
    </form>

    @php
        $grades = is_string($school->grades) ? json_decode($school->grades, true) : $school->grades;

        function getGrade($mark, $grades) {
            if ($mark === null || $mark === '') return '-';
            foreach ($grades as $grade => $range) {
                if ($mark >= $range['from'] && $mark <= $range['to']) {
                    return $grade;
                }
            }
            return '-';
        }
    @endphp

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Student No</th>
                <th>Student Name</th>
                @foreach($subjects as $subject)
                    <th>{{ ucfirst($subject) }}</th>
                @endforeach
                <th>Total</th>
                <th>Average</th>
                <th>Position</th>
            </tr>
        </thead>
        <tbody>
        @forelse($marks as $index => $mark)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mark->student_id }}</td>
                <td>{{ $mark->student_name }}</td>

                @foreach($subjects as $subject)
                    @php
                        $subjectMark = $mark->subjectMarks->first(function ($item) use ($subject) {
                            return strtolower(trim($item->subject_name)) === strtolower(trim($subject));
                        });

                        $score = $subjectMark->mark ?? 0;
                        $grade = getGrade($score, $grades);
                    @endphp
                    <td>{{ $score }} ({{ $grade }})</td>
                @endforeach

                <td>{{ $mark->total_marks }}</td>
                <td>{{ $mark->average_marks }} ({{ getGrade($mark->average_marks, $grades) }})</td>
                <td>{{ $mark->student_position }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ 5 + count($subjects) }}" class="text-center">No marks found for selected month or year.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
