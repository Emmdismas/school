<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="{{ asset('assets/css/loginn.css') }}">
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('logiin') }}">
            @csrf
            <div class="login-form">
                <h2>Login</h2>
                <div class="loginForm">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="name" required>
                    </div>
                    
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Login</button>
                </div>
            </div>
        </form>
        <p>Don't have an account? <a href="#" id="showSignup">Signup</a></p>
    </div>

    <script src="script.js"></script>
</body>
</html>