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
        <h2>Attendance Details - {{ $class }}</h2>
        <p><strong>Date:</strong> {{ $date }}</p>

        
         <!-- Summary Table -->
         <h3>Attendance Summary</h3>
        <table class="table table-bordered summary-table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Total Students</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Present</td>
                    <td>{{ count($presentStudents) }}</td>
                </tr>
                <tr>
                    <td>Absent</td>
                    <td>{{ count($absentStudents) }}</td>
                </tr>
                <tr>
                    <td>Sick</td>
                    <td>{{ count($sickStudents) }}</td>
                </tr>
                <tr>
                    <td>Not Allowed</td>
                    <td>{{ count($notAllowedStudents) }}</td>
                </tr>
            </tbody>
</table>
        <h3>Present Students</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Student No</th>
                    <th>Student Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($presentStudents as $key => $student)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->student_name }}</td>
                        <td>Present</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Absent Students</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Student No</th>
                    <th>Student Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absentStudents as $key => $student)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->student_name }}</td>
                        <td>Absent</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Sick Students</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Student No</th>
                    <th>Student Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sickStudents as $key => $student)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->student_name }}</td>
                        <td>Sick</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Not Allowed Students</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Student No</th>
                    <th>Student Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notAllowedStudents as $key => $student)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->student_name }}</td>
                        <td>Not Allowed</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
