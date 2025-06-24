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

        <table>
            <thead>
                <tr>
                    <th>Student No</th>
                    <th>Student Name</th>
                    <th>Payment Type</th>
                    <th>Amount</th>
                    <th>Academic Year</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->student_name }}</td>
                        <td>
                            <form action="{{ route('payments.store', $class) }}" method="POST">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $student->student_id }}">
                                <input type="hidden" name="student_name" value="{{ $student->student_name }}">
                                <select name="payment_type" required>
                                    <option value="Tuition">Tuition</option>
                                    <option value="Other Fee">Other Fee</option>
                                </select>
                        </td>
                        <td>
                                <input type="number" name="amount" placeholder="Amount" required>
                        </td>
                        <td>
                                <select name="academic_year" required>
                                    <option value="2024/25">2024/25</option>
                                    <option value="2025/26">2025/26</option>
                                    <option value="2026/27">2026/27</option>
                                </select>
                        </td>
                        <td>
                                <button type="submit" class="btn">Submit</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

