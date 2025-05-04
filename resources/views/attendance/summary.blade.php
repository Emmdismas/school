<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Summary - {{ $class }}</title>
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet"> <!-- External CSS -->
</head>
<body>
<div class="container">
    <h2 class="title">Attendance Summary - {{ $class }}</h2>

    @if($summary->isEmpty())
        <p class="alert alert-warning">No attendance records found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Sick</th>
                    <th>Not Allowed</th>
                    <th>Total Students</th>
                    <th>Percentage (%)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($summary as $record)
                    <tr>
                        <td>{{ $record->attendance_date }}</td>
                        <td>{{ $record->present }}</td>
                        <td>{{ $record->absent }}</td>
                        <td>{{ $record->sick }}</td>
                        <td>{{ $record->not_allowed }}</td>
                        <td>{{ $record->total_students }}</td>
                        <td>{{ number_format($record->percentage, 2) }}%</td>
                        <td>
                            <a href="{{ route('attendance.details', ['class' => $class, 'date' => $record->attendance_date]) }}" class="btn btn-info btn-sm">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

</body>
</html>
