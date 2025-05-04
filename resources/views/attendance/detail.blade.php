<div>
    <!-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius -->
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Attendance System</title>
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet"> <!-- External CSS -->
</head>
<body>
<div class="container">
    <h2 class="text-center mb-4">Attendance Details for {{ $class }}</h2>
        <h2>Attendance date :  {{ $date }}</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Number</th>
                <th>Student Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendanceDetails as $student)
            <tr>
                <td>{{ $student->student_id }}</td>
                <td>{{ $student->student_name }}</td>
                <td>{{ $student->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>