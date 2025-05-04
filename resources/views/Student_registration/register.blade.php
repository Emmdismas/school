<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <link rel="stylesheet" href="{{ asset('assets/css/student_register.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="registration-container">
        <h2>Student Registration Form</h2>
        <form class="registration-form" action="{{ route('student.register')}}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Student Number -->
            <label for="student_id">Student Number:</label>
            <input type="text" id="student_id" name="student_id" required>

            <!-- Student Name -->
            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" required>

            <!-- Gender -->
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <!-- Date of Birth -->
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required>

            <!-- Blood Group -->
            <label for="blood_group">Blood Group:</label>
            <input type="text" id="blood_group" name="blood_group" required>

            <!-- Parent Name -->
            <label for="parent_name">Parent Name:</label>
            <input type="text" id="parent_name" name="parent_name" required>

            <!-- Parent Number -->
            <label for="parent_number">Parent Number:</label>
            <input type="text" id="parent_number" name="parent_number" required>

            <!-- Parent Email -->
            <label for="parent_email">Parent Email:</label>
            <input type="email" id="parent_email" name="parent_email" required>

            <!-- Relationship -->
            <label for="relationship">Relationship:</label>
            <input type="text" id="relationship" name="relationship" required>

            <!-- Class -->
            <label for="class">Select Class:</label>
            <select name="class" id="class" required>
                <optgroup label="Primary School">
                    <option value="Standard_1">Standard 1</option>
                    <option value="Standard_2">Standard 2</option>
                    <option value="Standard_3">Standard 3</option>
                    <option value="Standard_4">Standard 4</option>
                    <option value="Standard_5">Standard 5</option>
                    <option value="Standard_6">Standard 6</option>
                    <option value="Standard_7">Standard 7</option>
                </optgroup>
                <optgroup label="Secondary School">
                    <option value="Form_1">Form 1</option>
                    <option value="Form_2">Form 2</option>
                    <option value="Form_3">Form 3</option>
                    <option value="Form_4">Form 4</option>
                    <option value="Form_5">Form 5</option>
                    <option value="Form_6">Form 6</option>
                </optgroup>
            </select>

            <!-- Upload Photo -->
            <label for="photo">Upload Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>

            <!-- Register Button -->
            <button type="submit">Register</button>
        </form>
    </div>

    <!-- JavaScript for pop-up -->
    @if(session('error'))
    <script type="text/javascript">
        var isConfirmed = confirm("{{ session('error') }}");

        if (isConfirmed) {
            // Redirect to the edit page for the student
            window.location.href = "/students/edit/{{ session('student_id') }}";
        } else {
            // Do nothing (remain on the current form)
            window.location.href = "/students/create";
        }
    </script>
@endif

</body>
</html>
