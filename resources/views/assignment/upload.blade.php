<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/assignment.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <h2>{{ $title }}</h2>
        </header>

        <!-- Assignment Form -->
        <form action="{{ route('assignments.store', ['class' => $class]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="assignmentName">Assignment Name:</label>
                <input type="text" id="assignmentName" name="assignment_name" placeholder="Enter assignment name" required>
            </div>

            <div class="form-group">
                <label for="assignmentType">Assignment Type:</label>
                <select id="assignmentType" name="assignment_type" required>
                    <option value="" disabled selected>Select assignment type</option>
                    <option value="homework">Homework</option>
                    <option value="homepackage">Homepackage</option>
                </select>
            </div>


            <div class="form-group">
                <label for="subjectMaster">Subject Master:</label>
                <input type="text" id="subjectMaster" name="subject_master" placeholder="Enter subject master" required>
            </div>

            <div class="form-group">
                <label for="deadline">Deadline:</label>
                <input type="date" id="deadline" name="deadline" required>
            </div>

            <div class="form-group">
                <label for="uploadFile">Upload Assignment:</label>
                <input type="file" id="uploadFile" name="upload_file" required>
            </div>

            <!-- Hidden fields for type and class -->
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="class" value="{{ $class }}">

            <button type="submit" class="btn-primary">Submit Assignment</button>
        </form>

        <!-- Notes Section -->
        <div class="note">
            <p><strong>Note:</strong></p>
            <ul>
                <li>Assignment uploaded must be 2 MB or less.</li>
                <li>Maximum storage for class is 30 MB.</li>
                <li>Assignments will disappear after 20 days.</li>
            </ul>
        </div>

        <!-- Display Assignments Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Subject Master</th>
                    <th>Deadline</th>
                    <th>Download</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="assignmentsTable">
            @foreach ($assignments as $assignment)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $assignment->assignment_name }}</td>
        <td>{{ $assignment->assignment_type }}</td>
        <td>{{ $assignment->subject_master }}</td>
        <td>{{ $assignment->deadline }}</td>

<td>
<a href="{{ route('assignments.download', ['type' => $type, 'class' => $class, 'id' => $assignment->id]) }}">Download</a>
</td>

        <td>
        <form action="{{ route('assignments.destroy', ['type' => $type, 'class' => $class, 'id' => $assignment->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>

        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<!-- Back to Home Button -->
<div style="margin-top: 20px; text-align: center;">
    <a href="{{ url('/teacher') }}" class="btn-back-home">← Back to Home</a>
</div>

    <script src="script.js"></script>
</body>
</html>
