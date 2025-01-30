 <!--<div>
    It is not the man who has too little, but the man who craves more, that is poor. - Seneca
</div>
-->
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

@section('content')

<head>
    <title>Student Table</title>
</head>
<body>
<div class="container">
<h2>Student list - {{ $class }} </h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>blood group</th>
            <th>Attendance (%)</th>
            <th>Payment (%)</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student->student_number }}</td>
                <td>{{ $student->student_name }}</td>
                <td>{{ $student->blood_group }}</td>
                <td>{{ $student->attendance }}</td>
                <td>{{ $student->payment }}</td>
                <td>{{ $student->parent_email }}</td>
                <td>{{ $student->parent_number }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
<button href="{{ route('student.create', ['class' => $class])
}}">Add students</button>

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



</body>

