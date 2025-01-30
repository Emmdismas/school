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

        <!-- Display Assignments Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Subject Matter</th>
                    <th>Deadline</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignments as $assignment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $assignment->assignment_name }}</td>
                    <td>{{ $assignment->subject_matter }}</td>
                    <td>{{ $assignment->deadline }}</td>
                    <td>
                        <a href="{{ route('assignments.download', ['type' => $type, 'class' => $class, 'id' => $assignment->id]) }}" class="btn">Download</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="script.js"></script>
</body>
</html>
