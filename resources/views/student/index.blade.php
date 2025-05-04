 <!--<div>
    It is not the man who has too little, but the man who craves more, that is poor. - Seneca
</div>
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Table</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    
</head>
<body>
<div class="container">
    <h2>Student List - {{ $class }}</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Blood Group</th>
                <th>Attendance (%)</th>
                <th>Payment (%)</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Year of Study</th>  <!-- ✅ Year of Study Added -->
                <th>Status</th>  <!-- ✅ Status Added -->
                <th>Full Profile</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->student_name }}</td>
                    <td>{{ $student->blood_group }}</td>
                    <td>{{ $student->attendance }}</td>
                    <td>{{ $student->payment }}</td>
                    <td>{{ $student->parent_email }}</td>
                    <td>{{ $student->parent_number }}</td>
                    <td>{{ $student->year_of_study }}</td>  <!-- ✅ Year of Study Column -->
                    <td>{{ $student->status }}</td>  <!-- ✅ Status Column -->
                    <td>
                        <a href="{{ route('students.fullProfile', ['student_id' => $student->student_id, 'school_id' => $student->school_id]) }}" class="btn profile-btn">
                            Full Profile
                        </a>
                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ✅ Button ya kuongeza wanafunzi sasa iko sahihi -->
    <a href="{{ route('student.create', ['class' => $class]) }}" class="btn btn-success">
        Add Student
    </a>

</div>

</body>


<script>
    // Calculate total marks and average
    document.querySelector('#studentsTable').addEventListener('input', function (e) {
        if (e.target.matches('input[type="number"]')) {
            const row = e.target.closest('tr');
            const subjects = row.querySelectorAll('input[name^="marks"][name$="[subject"]');
            let total = 0;

            subjects.forEach(subject => {
                total += parseInt(subject.value) || 0;
            });

            row.querySelector('input[name$="[total_marks]"]').value = total;
            row.querySelector('input[name$="[average]"]').value = (total / subjects.length).toFixed(2);
        }
    });
</script>



