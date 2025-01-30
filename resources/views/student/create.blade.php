    <!--<div>
 Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci 
</div>
-->
<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>

<h2>Add New Student</h2>

<form action="{{ route('students.store') }}" method="POST">
    @csrf
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="attendance">Attendance (%):</label>
    <input type="number" id="attendance" name="attendance" required><br>

    <label for="payment">Payment (%):</label>
    <input type="number" id="payment" name="payment" required><br>

    <label for="result">Result:</label>
    <input type="text" id="result" name="result" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" required><br>

    <button type="submit">Submit</button>
</form>

<a href="{{ route('students.index') }}">Back to Student Table</a>

</body>
</html>
