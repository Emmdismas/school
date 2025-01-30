@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
@endsection

@section('content')
<div class="container">
    <h2 class="text-center text-primary">Marks for {{ $class }}</h2>
    <h4 class="text-center text-secondary">Exam Type: <span class="text-info">{{ $examType }}</span></h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student No</th>
                <th>Student Name</th>
                <th>Subject 1</th>
                <th>Subject 2</th>
                <th>Subject 3</th>
                <th>Subject 4</th>
                <th>Subject 5</th>
                <th>Total</th>
                <th>Average</th>
                <th>Position</th>
            </tr>
        </thead>
        <tbody>
            @foreach($marks as $mark)
                <tr>
                    <td>{{ $mark->student_number }}</td>
                    <td>{{ $mark->student_name }}</td>
                    <td>{{ $mark->subject_1 }}</td>
                    <td>{{ $mark->subject_2 }}</td>
                    <td>{{ $mark->subject_3 }}</td>
                    <td>{{ $mark->subject_4 }}</td>
                    <td>{{ $mark->subject_5 }}</td>
                    <td>{{ $mark->total }}</td>
                    <td>{{ $mark->average }}</td>
                    <td>{{ $mark->student_position }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
