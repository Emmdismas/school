<div>
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
</div>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Accountant Registration Form</title>
    <link rel="stylesheet" href="{{ asset('assets/css/assignment.css') }}">
</head>

<body>
    <div class="container">
        <header>
            <h2>Accountant Registration Form</h2>
        </header>
        <form action="{{ route('accountant.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="school_name" value="{{ Auth::user()->school_name }}">
            <input type="hidden" name="school_id" value="{{ Auth::user()->school_id }}">

            <div class="form-group">
                <label for="name">Accountant name</label>
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

            <!-- Blood Group -->
            <div class="form-group">

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
                <label for="accountant_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" required>

            </div>

            <div class="form-group">
                <!-- Accountant Email -->
                <label for="Accountant_email">Accountant Email:</label>
                <input type="email" id="accountant_email" name="accountant_email" required>

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
                <label for="password">Accountant Password:</label>
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

            <button type="submit" class="btn-primary">Register Accountant</button>
        </form>

        <script>
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