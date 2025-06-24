<div>
    <!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
</div>
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
        <form method="POST" action="{{ route('marks.update', ['class' => $class]) }}">
    @csrf

    <input type="hidden" name="examType" value="{{ $examType }}">
    <input type="hidden" name="month" value="{{ $month }}">
    <input type="hidden" name="academic_year" value="{{ $academicYear }}">

    <table>
        <thead>
            <tr>
                <th>Student No</th>
                <th>Name</th>
                @foreach ($subjects as $subject)
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
                    @foreach ($subjects as $subject)
                        <td>
                            <input type="number"
                                name="students[{{ $index }}][subjects][{{ $subject }}]"
                                value="{{ $student['marks'][$subject] }}"
                                min="0"
                                max="100"
                                required>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit">Update Marks</button>
</form>


        <button onclick="window.location.href='{{ url('/') }}'" class="btn btn-secondary mt-3">Home</button>
    @endif
</div>
</body>
</html>
