<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <link rel="stylesheet" href="{{ asset('assets/css/student_register.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            <!-- Class Selection -->
            <label for="class">Select Class:</label>
            <select name="class" id="class" required>
                <!-- Options will be populated by JavaScript based on school type -->
            </select>

            <!-- Stream Selection (for Form 3-6 only) -->
            <div id="stream-section" style="display: none;">
                <label for="stream">Select Stream:</label>
                <select name="stream" id="stream">
                    <option value="">-- Select Stream --</option>
                    <option value="science">Science</option>
                    <option value="arts">Arts</option>
                    <option value="business">Business</option>
                </select>
            </div>

             <div class="form-group">
                <label for="name">Username:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>

          <div class="form-group">
                <label for="password">Student Password:</label>
                <input type="password" id="password" name="password" required>
                <div id="password-message" style="color: red; font-weight: bold;"></div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                <div id="confirm-message" style="color: red; font-weight: bold;"></div>
            </div>
            <!-- Upload Photo -->
            <label for="photo">Upload Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>

            <!-- Register Button -->
            <button type="submit">Register</button>
        </form>
    </div>


   <script>
    $(document).ready(function() {
        const schoolType = "{{ $schoolType }}";

        const classSelect = $('#class');
        classSelect.empty();

        if (schoolType === 'primary') {
            for (let i = 1; i <= 7; i++) {
                classSelect.append(`<option value="Standard_${i}">Standard ${i}</option>`);
            }
        } else if (schoolType === 'secondary' || schoolType === 'advance') {
            for (let i = 1; i <= 4; i++) {
                classSelect.append(`<option value="Form_${i}">Form ${i}</option>`);
            }
            if (schoolType === 'advance') {
                for (let i = 5; i <= 6; i++) {
                    classSelect.append(`<option value="Form_${i}">Form ${i}</option>`);
                }
            }
        }
        
        // Trigger change event to show/hide stream section
        $('#class').trigger('change');
        
        $('#class').change(function() {
            const selectedClass = $(this).val();
            if (selectedClass.startsWith('Form_')) {
                const formNumber = parseInt(selectedClass.split('_')[1]);
                if (formNumber >= 3) {
                    $('#stream-section').show();
                    $('#stream').prop('required', true);
                } else {
                    $('#stream-section').hide();
                    $('#stream').prop('required', false);
                }
            } else {
                $('#stream-section').hide();
                $('#stream').prop('required', false);
            }
        });
    });
</script>
</body>
</html>