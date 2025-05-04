<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Payment for {{ $class }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/payment.css') }}">
</head>
<body>
    <div class="container">
        <h2>Submit Payment for {{ $class }}</h2>
        <form action="{{ route('payments.store', $class) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="academic_year"><b>Academic Year:</b></label>
        <select name="academic_year" required>
            <option value="2024/25">2024/25</option>
            <option value="2025/26">2025/26</option>
            <option value="2026/27">2026/27</option>
            <option value="2027/28">2027/28</option>
            <option value="2028/29">2028/29</option>
            <option value="2029/30">2029/30</option>
        </select>

        <table>
    <thead>
        <tr>
            <th>Student No</th>
            <th>Stud Name</th>
            <th>Payment Type</th>
            <th>Amount</th>
            <th>Upload Receipt</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($students as $student)
        <tr>
            <form action="{{ route('payments.store', $class) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->student_id }}">
                <input type="hidden" name="student_name" value="{{ $student->student_name }}">

                <td>{{ $student->student_id }}</td>
                <td>{{ $student->student_name }}</td>
                <td>
                    <select name="payment_type" required>
                        <option value="Tuition">Tuition</option>
                        <option value="Bus Fee">Bus Fee</option>
                    </select>
                </td>
                <td>
                    <input type="number" name="amount" placeholder="Amount" required>
                </td>
                <td>
                    <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf" required>
                </td>
                <td>
                    <input type="hidden" name="academic_year" value="2024/25"> <!-- You can change this to dynamic -->
                    <button type="submit" class="btn">Submit</button>
                </td>
            </form>
        </tr>
    @endforeach
</tbody>

</table>
        </form>
    </div>
</body>
</html>
