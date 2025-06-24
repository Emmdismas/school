<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="{{ asset('assets/css/assignment.css') }}">
</head>

<body>
    <div class="container">
        <header>
            <h2>Teacher Registration Form</h2>
        </header>
        <form action="{{ route('teacher.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="school_name" value="{{ Auth::user()->school_name }}">
            <input type="hidden" name="school_id" value="{{ Auth::user()->school_id }}">

            <div class="form-group">
                <label for="name">Teacher name</label>
                <input type="text" id="name" name="full_name" placeholder="Enter your name" required>
            </div>
            <!-- Gender -->

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <!-- Date of Birth -->
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required>
            </div>

            <div class="form-group">
                <!-- Blood Group -->
                <label for="blood_group">Blood Group:</label>
                @php
                    $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                @endphp

                <select id="blood_group" name="blood_group" required>
                    <option value="">--Select Blood Group--</option>
                    @foreach($bloodGroups as $group)
                        <option value="{{ $group }}">{{ $group }}</option>
                    @endforeach
                </select>

            </div>

            <div class="form-group">
                <!-- Phone Number -->
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" required>

            </div>

            <div class="form-group">
                <!-- Teacher Email -->
                <label for="teacher_email">Teacher Email:</label>
                <input type="email" id="teacher_email" name="teacher_email" required>

            </div>

            
            <div class="form-group">
                <label for="nida_number">NIDA Number:</label>
                <input type="text" id="nida_number" name="nida_number" placeholder="Enter NIDA number" required>
            </div>


            <div class="form-group">
                <label for="name">City:</label>
                <input type="text" id="city" name="city" placeholder="enter your city name" required>
            </div>

            <div class="form-group">
                <label for="name">District:</label>
                <input type="text" id="district" name="district" placeholder="enter your district name" required>
            </div>

            <div class="form-group">
                <label for="name">Current Address:</label>
                <input type="text" id="address" name="address" placeholder="enter your Current address" required>
            </div>

            <div class="form-group">
                <label for="name">UserName:</label>
                <input type="text" id="name" name="username" placeholder="enter username" required>
            </div>


            <div class="form-group">
                <label for="password">Teacher Password:</label>
                <input type="password" id="password" name="password" required>
                <div id="password-message" style="color: red; font-weight: bold;"></div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                <div id="confirm-message" style="color: red; font-weight: bold;"></div>
            </div>
            
            <div class="form-group">
            <!-- Upload Photo -->
            <label for="photo">Upload Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>

    </div>


    <div class="formm-group mb-4">
        <label>
            @if ($schoolType === 'advance')
                Select Subjects You Teach Based on Combinations (Form 5 & 6):
            @elseif ($schoolType === 'secondary')
                Select Subjects You Teach (Form 1 - 4):
            @else
                <h2>Select Subjects You Teach</h2>
            @endif
        </label>

        <table class="table table-bordered table-striped mt-3">
            <thead class="table-light">
                <tr>
                    <th>Class</th>
                    @foreach($subjects as $subject)
                        <th>{{ $subject }}</th>
                    @endforeach
                </tr>
            </thead>
           <tbody>
    @php /** @var array $classes */ @endphp
    @foreach($classes as $class)
        <tr>
            <td><strong>{{ $class }}</strong></td>
            @foreach($subjects as $subject)
                <td class="text-center">
                    <input type="checkbox" name="teaching[{{ $class }}][]" value="{{ $subject }}">
                </td>
            @endforeach
        </tr>
    @endforeach
</tbody>

        </table>
    </div>



    <div class="form-group">
        <label>Are you a class teacher?</label>
        <label><input type="checkbox" id="is_class_teacher" name="is_class_teacher" onchange="toggleClassDropdown()">
            Yes</label>
    </div>

    <div class="form-group" id="class_incharge_div" style="display:none;">
        <label for="class_incharge">Select Class In-Charge:</label>
        <select name="class_incharge" id="class_incharge">
            <option value="">--Select--</option>
            @foreach(['Standard 1', 'Standard 2', 'Standard 3', 'Standard 4', 'Standard 5', 'Standard 6', 'Standard 7'] as $class)
                <option value="{{ $class }}">{{ $class }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn-primary">Register Teacher</button>
    </form>

    <script>
        function toggleClassDropdown() {
            const checkbox = document.getElementById('is_class_teacher');
            const div = document.getElementById('class_incharge_div');
            div.style.display = checkbox.checked ? 'block' : 'none';
        }
       const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("password_confirmation");
    const form = document.querySelector("form");

    const passwordMsg = document.getElementById("password-message");
    const confirmMsg = document.getElementById("confirm-message");

    // Live validation ya password length
    passwordInput.addEventListener("input", function () {
        if (passwordInput.value.length < 8) {
            passwordMsg.textContent = "Password must be at least 8 characters.";
        } else {
            passwordMsg.textContent = "";
        }

        // Check kama password na confirm zinafanana live
        if (confirmInput.value !== "" && passwordInput.value !== confirmInput.value) {
            confirmMsg.textContent = "Passwords do not match.";
        } else {
            confirmMsg.textContent = "";
        }
    });

    // Live check ya confirmation
    confirmInput.addEventListener("input", function () {
        if (confirmInput.value !== passwordInput.value) {
            confirmMsg.textContent = "Passwords do not match.";
        } else {
            confirmMsg.textContent = "";
        }
    });

    // Final validation kabla ya ku-submit form
    form.addEventListener("submit", function (e) {
        let hasError = false;

        if (passwordInput.value.length < 8) {
            passwordMsg.textContent = "Password must be at least 8 characters.";
            hasError = true;
        }

        if (confirmInput.value !== passwordInput.value) {
            confirmMsg.textContent = "Passwords do not match.";
            hasError = true;
        }

        if (hasError) e.preventDefault(); // zuia submission kama kuna kosa
    });

    </script>

    </div>
</body>

</html>