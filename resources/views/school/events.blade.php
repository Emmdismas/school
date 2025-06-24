<div>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
</div>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/assignment.css') }}">
</head>
<body></body>
@php
    $user = \App\Helpers\UserHelper::getLoggedInUser();
@endphp

<form method="POST" action="{{ route('school-events.store') }}">
    @csrf

    <input type="hidden" name="school_id" value="{{ $user?->school_id }}">
    <input type="hidden" name="user_id" value="{{ $user?->id }}">
    <input type="hidden" name="school_type" value="{{ $user?->school_type }}">

    <div class="mb-3">
        <label for="event_type" class="form-label">Aina ya Tukio</label>
        <select name="event_type" class="form-control" required>
            <option value="emergency">Taarifa ya Dharura</option>
            <option value="normal">Matukio ya Kawaida</option>
            <option value="discipline">Matukio ya Nidhamu</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="title" class="form-label">Kichwa cha Tukio</label>
        <input type="text" class="form-control" name="title" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Maelezo</label>
        <textarea class="form-control" name="description" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label for="event_date" class="form-label">Tarehe ya Tukio</label>
        <input type="date" class="form-control" name="event_date" required>
    </div>

    <button type="submit" class="btn btn-primary">Hifadhi Tukio</button>
</form>
</body>
</html>
