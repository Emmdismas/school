<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Table</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    
</head>
<body>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h2>Student Full Profile - {{ strtoupper($student->student_name) }}</h2>
        </div>
        <div class="card-body">
            <!-- Taarifa za Msingi za Mwanafunzi -->
            <div class="text-center">
            <img src="data:image/jpeg;base64,{{ base64_encode($student->photo) }}?{{ time() }}" class="rounded-circle" width="150" height="150" alt="Student Photo">

            </div>
            <table class="table table-bordered mt-3">
                <tr><th>Student Number:</th><td>{{ $student->student_id }}</td></tr>
                <tr><th>Name:</th><td>{{ $student->student_name }}</td></tr>
                <tr><th>Class:</th><td>{{ strtoupper($student->class) }}</td></tr>
                <tr><th>Blood Group:</th><td>{{ $student->blood_group }}</td></tr>
                <tr><th>Email:</th><td>{{ $student->parent_email }}</td></tr>
                <tr><th>Phone:</th><td>{{ $student->parent_number }}</td></tr>
            </table>

            <!-- Sehemu ya Mahudhurio -->
            <h3>Attendance Records</h3>
            @if ($attendances->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total Classes Attended</th>
                            <th>Total Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->attendance_date }}</td>
                                <td>{{ $attendance->status }}</td>
                                <td>{{ $attendance->total_classes_attended }}</td>
                                <td>{{ $attendance->total_percentage }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No attendance records found.</p>
            @endif

            <!-- Sehemu ya Malipo -->
            <h3>Payment Records</h3>
            @if ($payments->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Payment Type</th>
                            <th>Amount</th>
                            <th>Receipt Content</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_type }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->receipt_content }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No payment records found.</p>
            @endif
        </div>
    </div>
</div>
</body>