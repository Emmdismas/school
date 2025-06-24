<div>
    <!-- Order your soul. Reduce your wants. - Augustine -->
</div>
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
    <h4>Status ya Ujumbe wa Matokeo</h4>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Mwanafunzi</th>
                <th>Namba ya Mzazi</th>
                <th>Hali</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student['student_name'] }}</td>
                    <td>{{ $student['parent_phone'] }}</td>
                    <td>
                        @if($student['notified'])
                            <span class="badge bg-success">Imetumwa ✅</span>
                        @else
                            <span class="badge bg-danger">Bado ❌</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>