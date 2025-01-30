@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
@endsection

@section('content')
<div class="container">
    <header>
        <h2>Attendance for {{ $class }}</h2>
    </header>

    <!-- Attendance Form -->
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
                        <td>{{ $student->student_number }}</td>
                        <td>{{ $student->student_name }}</td>
                        <td><input type="checkbox" class="status-checkbox" data-student="{{ $student->student_number }}" name="students[{{ $student->student_number }}][status]" value="Present"></td>
                        <td><input type="checkbox" class="status-checkbox" data-student="{{ $student->student_number }}" name="students[{{ $student->student_number }}][status]" value="Absent"></td>
                        <td><input type="checkbox" class="status-checkbox" data-student="{{ $student->student_number }}" name="students[{{ $student->student_number }}][status]" value="Sick"></td>
                        <td><input type="checkbox" class="status-checkbox" data-student="{{ $student->student_number }}" name="students[{{ $student->student_number }}][status]" value="Not Allowed"></td>
                        <td>{{ $student->total_classes_attended ?? 0 }}</td>
                        <td>{{ number_format($student->total_percentage ?? 0, 2) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Submit Attendance</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.status-checkbox');
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const studentId = this.dataset.student;
                checkboxes.forEach(function (cb) {
                    if (cb !== checkbox && cb.dataset.student === studentId) {
                        cb.checked = false;
                    }
                });
            });
        });
    });
</script>
@endsection
