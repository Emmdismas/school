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

        <!-- Select Class Section -->
       <!-- Select Assignment Type -->
<form method="GET" action="{{ route('assignments.index', ['class' => $class]) }}">
    <div style="width: 100%; display: flex; flex-direction: column; gap: 20px;">

        <div>
            <label for="typeSelect"><b>Select Assignment Type:</b></label><br></br>
            <select name="assignment_type" id="typeSelect" required style="width: 100%; padding: 8px;">
                <option value="" disabled selected>-- Select Type --</option>
                <option value="homework">Homework</option>
                <option value="homepackage">Homepackage</option>
            </select>
        </div>

        <div>
            <button type="submit" class="btn" style="width: 100%; padding: 10px; color: white; background-color: #4154f1;">Fetch Assignments</button>
        </div>

    </div>
</form>



        <!-- Display Assignments Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Subject Master</th>
                    <th>Deadline</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignments as $assignment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $assignment->assignment_name }}</td>
                    <td>{{ $assignment->subject_master }}</td>
                    <td>{{ $assignment->deadline }}</td>
                    <td>
                        <a href="{{ route('assignments.download', ['type' => $type, 'class' => $class, 'id' => $assignment->id]) }}" class="btn">Download</a>
                    </td>
                </tr>
                @endforeach

                @if ($assignments->isEmpty())
                <tr>
                    <td colspan="5" style="text-align:center;">No assignments found for this class.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div style="margin-top: 20px; text-align: center;">
    <a href="{{ url('/teacher') }}" class="btn-back-home">← Back to Home</a>
</div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
