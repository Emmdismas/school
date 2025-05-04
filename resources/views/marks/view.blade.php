<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks - School Management System</title>
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet"> <!-- External CSS -->
</head>

<body>
<div class="container">
    <h2 class="text-center text-primary">Marks for {{ $class }}</h2>
    <h4 class="text-center text-secondary">Exam Type: <span class="text-info">{{ $examType }}</span></h4>

    <!-- Month Selection Form -->
    <form method="GET" action="{{ route('marks.show', ['class' => $class, 'examType' => $examType]) }}" class="text-center mb-3">


             <!-- Aina ya Mtihani -->
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
        @php
            $monthName = date('F', mktime(0, 0, 0, $m, 1)); // Pata jina la mwezi (e.g., "January")
        @endphp
        <option value="{{ $monthName }}" {{ $selectedMonth == $monthName ? 'selected' : '' }}>
            {{ $monthName }}
        </option>
    @endfor
</select>
<br></br>
<!-- Mwaka wa Masomo -->
<label for="academic_year"><b>Academic Year:</b></label>
            <select name="academic_year" id="academic_year">
                @foreach (['2024/25', '2025/26', '2026/27', '2027/28', '2028/29', '2029/30'] as $year)
                    <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>

        <button type="submit" class="btn btn-primary">Fetch Marks</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S/N</th> 
                <th>Student No</th>
                <th>Student Name</th>
                <th>Subject 1</th>
                <th>Subject 2</th>
                <th>Subject 3</th>
                <th>Subject 4</th>
                <th>Subject 5</th>
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
                    <td>{{ $mark->subject_1 }}</td>
                    <td>{{ $mark->subject_2 }}</td>
                    <td>{{ $mark->subject_3 }}</td>
                    <td>{{ $mark->subject_4 }}</td>
                    <td>{{ $mark->subject_5 }}</td>
                    <td>{{ $mark->total_marks }}</td>
                    <td>{{ $mark->average_marks }}</td>
                    <td>{{ $mark->student_position }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No marks found for selected month.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
