@extends('layouts.app')

@yield('css')
<link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">

@section('content')
<div class="container">
    <h2>Upload Marks for {{ $class }}</h2>

    @if($students->isEmpty())
    <p>No students found for {{ $class }}.</p>
@else

    <form id="marksForm" method="POST" action="{{ route('marks.store') }}">
        @csrf
        <input type="hidden" name="class" value="{{ $class }}">

        <!-- Dropdown exam type -->
        <div class="form-group">
            <label for="exam_type">Select Examination Type:</label>
            <select id="exam_type" name="exam_type" class="form-control">
                <option value="Midterm">Midterm</option>
                <option value="Terminal">Terminal</option>
            </select>
        </div>

        <!-- student table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Student Name</th>
                    <th>Subject 1</th>
                    <th>Subject 2</th>
                    <th>Subject 3</th>
                    <th>Subject 4</th>
                    <th>Subject 5</th>
                    <th>Total Marks</th>
                    <th>Average</th>
                </tr>
            </thead>
            <tbody>
                @@if ($students->isEmpty())
    <tr>
        <td colspan="7">No students found for {{ $class }}</td>
    </tr>

    @foreach($names as $student)
        <tr>
            <td>{{ $student->student_number }}</td>
            <td>{{ $student->student_name }}</td>
            <td><input type="number" name="marks[{{ $student->id }}][subject1]" class="form-control"></td>
            <td><input type="number" name="marks[{{ $student->id }}][subject2]" class="form-control"></td>
            <td><input type="number" name="marks[{{ $student->id }}][subject3]" class="form-control"></td>
            <td><input type="number" name="marks[{{ $student->id }}][subject4]" class="form-control"></td>
            <td><input type="number" name="marks[{{ $student->id }}][subject5]" class="form-control"></td>
        </tr>
    @endforeach
@endif

            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Save Marks</button>
    </form>
</div>
@endsection
