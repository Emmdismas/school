<!-- resources/views/students/edit.blade.php -->
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
    <h1>Edit Student</h1>

    <!-- Form ya edit -->
    <form action="{{ route('students.update', $student->student_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Gender -->
    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
        <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
        <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
    </select>

    <!-- Date of Birth -->
    <label for="date_of_birth">Date of Birth:</label>
    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}" required>

    <!-- Blood Group -->
    <label for="blood_group">Blood Group:</label>
    <input type="text" id="blood_group" name="blood_group" value="{{ old('blood_group', $student->blood_group) }}" required>

    <!-- Parent Name -->
    <label for="parent_name">Parent Name:</label>
    <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}" required>

    <!-- Parent Number -->
    <label for="parent_number">Parent Number:</label>
    <input type="text" id="parent_number" name="parent_number" value="{{ old('parent_number', $student->parent_number) }}" required>

    <!-- Parent Email -->
    <label for="parent_email">Parent Email:</label>
    <input type="email" id="parent_email" name="parent_email" value="{{ old('parent_email', $student->parent_email) }}" required>

    <!-- Relationship -->
    <label for="relationship">Relationship:</label>
    <input type="text" id="relationship" name="relationship" value="{{ old('relationship', $student->relationship) }}" required>

    <button type="submit">Update Student</button>
</form>

</body>
</html>
