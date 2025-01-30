 <!-- <div>
   The only way to do great work is to love what you do. - Steve Jobs 
</div>
-->
<!-- resources/views/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="{{ asset('registration/css/styles.css') }}">
</head>
<body>
    <h2>Student Registration Form</h2>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('student.register') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="student_number">Student Number:</label>
        <input type="text" name="student_number" required><br>

        <label for="student_name">Student Name:</label>
        <input type="text" name="student_name" required><br>

        <label for="gender">Gender:</label>
        <select name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth" required><br>

        <label for="blood_group">Blood Group:</label>
        <input type="text" name="blood_group" required><br>

        <label for="parent_name">Parent Name:</label>
        <input type="text" name="parent_name" required><br>

        <label for="parent_number">Parent Number:</label>
        <input type="text" name="parent_number" required><br>

        <label for="parent_email">Parent Email:</label>
        <input type="email" name="parent_email" required><br>

        <label for="relationship">Relationship:</label>
        <input type="text" name="relationship" required><br>

        <label for="class">Class:</label>
        <select name="class" required>
            <option value="A">Class A</option>
            <option value="B">Class B</option>
            <option value="C">Class C</option>
        </select><br>

        <label for="photo">Upload Photo:</label>
        <input type="file" name="photo" accept="image/*" required><br>

        <button type="submit">Register</button>
    </form>
    <script src="{{ asset('registration/js/scripts.js') }}"></script>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

</body>
</html>
