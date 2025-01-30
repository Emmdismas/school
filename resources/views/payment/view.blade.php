<div>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Records for {{ $class }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/payment.css') }}">
</head>
<body>
    <div class="container">
        <h2>Payment Records for {{ $class }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Stud Name</th>
                    <th>Payment Type</th>
                    <th>Amount</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->student_id }}</td>
                        <td>{{ $payment->student->name }}</td>
                        <td>{{ $payment->payment_type }}</td>
                        <td>${{ $payment->amount }}</td>
                        <td>
                            @if($payment->receipt_content)
                                <a href="{{ route('download.receipt', ['class' => $class, 'id' => $payment->id]) }}" class="btn">Download</a>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
