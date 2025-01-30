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
            <table>
                <thead>
                    <tr>
                        <th>Student no</th>
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
                            <td>{{ $student->student_number }}</td>
                            <td>{{ $student->student_name }}</td>
                            <td>
                                <select name="payment_type[{{ $student->id }}]" required>
                                    <option value="Tuition">Tuition</option>
                                    <option value="Bus Fee">Bus Fee</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="amount[{{ $student->id }}]" placeholder="Amount" required>
                            </td>
                            <td>
                                <input type="file" name="receipt[{{ $student->id }}]" accept=".jpg,.jpeg,.png,.pdf" required>
                            </td>
                            <td>
                                <button type="submit" class="btn">Submit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>
