<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance for {{ $class }}</title>
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <header>
        <h2>Attendance for {{ $class }}</h2>
    </header>

    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('attendance.store', ['class' => $class]) }}">
        @csrf
        <div class="form-group">
            <label for="date">Attendance Date:</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Student Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Sick</th>
                    <th>Not Allowed</th>
                    <th>Total Classes Attended</th>
                    <th>Attendance Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->student_name }}</td>
                        <td>
                                    <input type="checkbox" class="status-checkbox" name="students[{{ $student->student_id }}][status]" value="Present" data-student="{{ $student->student_id }}">
                                </td>
                                <td>
                                    <input type="checkbox" class="status-checkbox" name="students[{{ $student->student_id }}][status]" value="Absent" data-student="{{ $student->student_id }}">
                                </td>
                                <td>
                                    <input type="checkbox" class="status-checkbox" name="students[{{ $student->student_id }}][status]" value="Sick" data-student="{{ $student->student_id }}">
                                </td>
                                <td>
                                    <input type="checkbox" class="status-checkbox" name="students[{{ $student->student_id }}][status]" value="Not Allowed" data-student="{{ $student->student_id }}">
                                </td>

                        <td>{{ $student->total_classes_attended ?? 0 }}</td>
                        <td>{{ number_format($student->total_percentage ?? 0, 2) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Submit Attendance</button>
        <div class="status-summary mt-4">
        <h3>Attendance Status Summary</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Status</th>
                    <th>Number of Students</th>
                </tr>
            </thead>
            <tbody>
            @php
    $statusCounts = session('statusCounts', []);
@endphp

<tr>
    <td>1</td>
    <td>Present</td>
    <td>{{ $statusCounts['Present'] ?? 0 }}</td>
</tr>
<tr>
    <td>2</td>
    <td>Absent</td>
    <td>{{ $statusCounts['Absent'] ?? 0 }}</td>
</tr>
<tr>
    <td>3</td>
    <td>Sick</td>
    <td>{{ $statusCounts['Sick'] ?? 0 }}</td>
</tr>
<tr>
    <td>4</td>
    <td>Not Allowed</td>
    <td>{{ $statusCounts['Not Allowed'] ?? 0 }}</td>
</tr>

            </tbody>
        </table>
    </div>
    </form>
</div>


</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.status-checkbox');

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            let studentId = this.dataset.student;

            // Pata checkboxes zote za mwanafunzi huyu
            let studentCheckboxes = document.querySelectorAll(`input[data-student="${studentId}"]`);

            // Zima nyingine kama moja imechaguliwa
            studentCheckboxes.forEach(function (cb) {
                if (cb !== checkbox) {
                    cb.checked = false;
                }
            });
        });
    });
});

</script>
</html>