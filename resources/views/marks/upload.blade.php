<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Marks - School Management System</title>
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet"> <!-- External CSS -->
</head>

<body>
<div class="container">

    <h2>Upload Marks for {{ $class }}</h2>

    @if(isset($studentsWithMarks) && $studentsWithMarks->isEmpty())
        <p>No students found for {{ $class }}.</p>
    @else
        <form method="POST" action="{{ route('marks.store', ['class' => $class]) }}">
            @csrf

            <input type="hidden" name="class" value="{{ $class }}">


                        <!-- Aina ya Mtihani -->
            <label for="examType"><b>Select Exam Type:</b></label>
            <select name="examType" id="examType" required>
                @foreach (['Mock', 'Terminal', 'Midterm', 'Test'] as $exam)
                    <option value="{{ $exam }}" {{ request('examType') == $exam ? 'selected' : '' }}>{{ $exam }}</option>
                @endforeach
            </select>
            <br><br>


            <!-- Mwezi Selection -->
            <label for="month"><b>Select Month:</b></label>
            <select name="month" id="month">
                @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                @endforeach
            </select>
            <br></br>

            <!-- Mwaka wa Masomo -->
            <label for="academic_year"><b>Academic Year:</b></label>
            <select name="academic_year" id="academic_year">
                @foreach (['2024/25', '2025/26', '2026/27', '2027/28', '2028/29', '2029/30'] as $year)
                    <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>

            <!-- Student Table -->
            <table class="table table-bordered">
                <thead>
    <tr>
        <th>Student No</th>
        <th>Student Name</th>
        @foreach($subjects as $subject)
            <th>{{ $subject }}</th>
        @endforeach
    </tr>
</thead>

                <tbody>
                    @foreach ($studentsWithMarks as $index => $student)
                        <tr>
                            <td>
                                {{ $student['student_id'] }}
                                <input type="hidden" name="students[{{ $index }}][student_id]" value="{{ $student['student_id'] }}">
                            </td>

                            <td>
                                {{ $student['student_name'] }}
                                <input type="hidden" name="students[{{ $index }}][student_name]" value="{{ $student['student_name'] }}">
                            </td>

                            <!-- Alama za Masomo -->
                           @foreach ($subjects as $subject)
                            <td>
                                <input type="number"
                                    name="students[{{ $index }}][subjects][{{ $subject }}]"
                                    value="{{ $student[$subject] ?? '' }}"
                                    min="0"
                                    max="100"
                                    required>
                            </td>
                        @endforeach


                           
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary mt-3">Submit Marks</button>
        </form>

        <button onclick="window.location.href='{{ url('/') }}'" class="btn btn-secondary mt-3">Home</button>
    @endif
</div>
</body>
</html>
