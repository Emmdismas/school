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
            <<thead>
    <tr>
        <th>Student ID</th>
        <th>Student Name</th>
        <th>Payment Type</th>
        <th>Total Paid (Tsh)</th>
        <th>Remained (Tsh)</th>
        <th>Total %</th>
        
    </tr>
</thead>
<tbody>
    @foreach ($payments as $payment)
        @php
            $totalPaid = (int)$payment->total_paid;
            $percentage = round(($totalPaid / $totalFee) * 100, 1);
            $remained = max($totalFee - $totalPaid, 0);
        @endphp
        <tr>
            <td>{{ $payment->student_id }}</td>
            <td>{{ $payment->student_name }}</td>
            <td>{{ $payment->payment_type }}</td>
            <td>{{ number_format($totalPaid) }}</td>
            <td>{{ number_format($remained) }}</td>
            <td>{{ $percentage }}%</td>
            
        </tr>
    @endforeach
</tbody>

        </table>
    </div>
</body>
</html>
