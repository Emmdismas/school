<!DOCTYPE html>
<html>
<head>
    <title>Student Profile PDF</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Student Profile - {{ strtoupper($student->name) }}</h2>
    <table>
        <tr><th>Student Number:</th><td>{{ $student->student_id }}</td></tr>
        <tr><th>Name:</th><td>{{ $student->name }}</td></tr>
        <tr><th>Class:</th><td>{{ strtoupper($student->class) }}</td></tr>
        <tr><th>Blood Group:</th><td>{{ $student->blood_group }}</td></tr>
        <tr><th>Attendance (%):</th><td>{{ $student->attendance->percentage ?? 'N/A' }}</td></tr>
        <tr><th>Payment (%):</th><td>{{ $student->payment->amount ?? 'N/A' }}</td></tr>
        <tr><th>Email:</th><td>{{ $student->email }}</td></tr>
        <tr><th>Phone:</th><td>{{ $student->phone }}</td></tr>
    </table>
</body>
</html>
