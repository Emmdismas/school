<div>
    <!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
</div>

<!-- resources/views/attendance/summary.blade.php -->

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
@endsection
@section('content')
<div class="container">
    <h2 class="text-center mb-4">Attendance Summary {{ $class }}</h2>

    <!-- Tarehe ya mahudhurio -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Present</th>
                <th>Absent</th>
                <th>Sick</th>
                <th>Not Allowed</th>
                <th>Attendance Percentage</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($summary as $record)
            <tr>
                <td>{{ $record->attendance_date }}</td>
                <td>{{ $record->present }}</td>
                <td>{{ $record->absent }}</td>
                <td>{{ $record->sick }}</td>
                <td>{{ $record->not_allowed }}</td>
                <td>{{ number_format($record->percentage, 2) }}%</td>
                <td>
                <a href="{{ route('attendance.detail', ['class' => 'ClassA', 'date' => $record->attendance_date ?? '']) }}">
    View
</a>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
