@extends('layouts.app')

@yield('css')
<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

@section('content')
<div class="container">

    <h2>Upload Marks for {{ $class }}</h2>

    @if(isset($studentsWithMarks) && $studentsWithMarks->isEmpty())
        <p>No students found for {{ $class }}.</p>
    @else
    <form id="marksForm" method="POST" action="{{ route('marks.store', ['examType' => $examType, 'class' => $class]) }}">

    @csrf
    <input type="hidden" name="examType" value="{{ $examType }}">
    <input type="hidden" name="class" value="{{ $class }}">
    <!-- Additional form fields -->



            @if(isset($examType) && !empty($examType))
    <h4 class="text-center text-secondary">
        Exam Type: <span class="text-info">{{ $examType }}</span>
    </h4>
@else
    <p class="text-danger">Exam type is missing. Please provide an exam type.</p>
@endif

            <!-- Student Table -->
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
                    @foreach ($studentsWithMarks as $student)
                        <tr>
                            <!-- Display Student No -->
                            <td>
                                {{ $student['student_number'] }}
                                <input type="hidden" name="students[{{ $loop->index }}][student_number]" value="{{ $student['student_number'] }}">
                            </td>

                            <!-- Display Student Name -->
                            <td>
                                {{ $student['student_name'] }}
                                <input type="hidden" name="students[{{ $loop->index }}][student_name]" value="{{ $student['student_name'] }}">
                            </td>

                            <!-- Input Fields for Marks -->
                            <td>
                                <input type="number"
                                       name="students[{{ $loop->index }}][subject1]"
                                       value="{{ $student['subject1'] ?? '' }}"
                                       min="0"
                                       max="100"
                                       required>
                            </td>
                            <td>
                                <input type="number"
                                       name="students[{{ $loop->index }}][subject2]"
                                       value="{{ $student['subject2'] ?? '' }}"
                                       min="0"
                                       max="100"
                                       required>
                            </td>
                            <td>
                                <input type="number"
                                       name="students[{{ $loop->index }}][subject3]"
                                       value="{{ $student['subject3'] ?? '' }}"
                                       min="0"
                                       max="100"
                                       required>
                            </td>
                            <td>
                                <input type="number"
                                       name="students[{{ $loop->index }}][subject4]"
                                       value="{{ $student['subject4'] ?? '' }}"
                                       min="0"
                                       max="100"
                                       required>
                            </td>
                            <td>
                                <input type="number"
                                       name="students[{{ $loop->index }}][subject5]"
                                       value="{{ $student['subject5'] ?? '' }}"
                                       min="0"
                                       max="100"
                                       required>
                            </td>

                            <td>
                                {{ $student['TotalMarks'] }}
                                <input type="hidden" name="students[{{ $loop->index }}][TotalMarks]" value="{{ $student['student_name'] }}">
                            </td>

                            <td>
                                {{ $student['averageMarks'] }}
                                <input type="hidden" name="students[{{ $loop->index }}][averageMarks]" value="{{ $student['student_name'] }}">
                            </td>

                            <td>
                                {{ $student['position'] }}
                                <input type="hidden" name="students[{{ $loop->index }}][position]" value="{{ $student['student_name'] }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary mt-3">Submit Marks</button>
        </form>
        <button onclick="window.location.href='{{ url('/') }}'" class="btn btn-secondary mt-3">Home</button>

    @endif
</div>
@endsection
