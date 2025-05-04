<div>
    <!-- He who is contented is rich. - Laozi -->
</div>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Full Profile</title>
    <style>
        /* Styles zilizopunguzwa au zilizobadilishwa ili kufanya PDF ionekane vizuri */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
        .section {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 5px;
        }
    </style>
</head>
<body>

<div class="profile-header">
    <h1>Student Full Profile</h1>
    @if($student->photo_path)
        <img src="{{ public_path('storage/' . $student->photo_path) }}" alt="Student Photo" class="profile-photo">
    @endif
    <h2>{{ $student->name }}</h2>
</div>

<div class="section">
    <h3>Student Details</h3>
    <p><strong>Date of Birth:</strong> {{ $student->dob }}</p>
    <p><strong>Class:</strong> {{ $student->class }}</p>
    <p><strong>Nationality:</strong> {{ $student->nationality }}</p>
    <p><strong>Religion:</strong> {{ $student->religion }}</p>
    <p><strong>Blood Group:</strong> {{ $student->blood_group }}</p>
</div>

<div class="section">
    <h3>Parent/Guardian Information</h3>
    @if($student->parent)
        <p><strong>Parent's Name:</strong> {{ $student->parent->name }}</p>
        <p><strong>Contact Number:</strong> {{ $student->parent->phone }}</p>
        <p><strong>Email:</strong> {{ $student->parent->email }}</p>
    @else
        <p>Parent information not available.</p>
    @endif
</div>

<div class="section">
    <h3>Attendance</h3>
    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Academic Year</th>
                <th>Attendance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($student->attendances as $attendance)
                <tr>
                    <td>{{ $attendance->month }}</td>
                    <td>{{ $attendance->academic_year }}</td>
                    <td>{{ $attendance->attendance }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Results</h3>
    @foreach($student->results->groupBy('exam_type') as $examType => $results)
        <h4>{{ $examType }} Exam</h4>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Marks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr>
                        <td>{{ $result->subject }}</td>
                        <td>{{ $result->marks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</div>

</body>
</html>
