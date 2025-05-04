<div>
    <!-- He who is contented is rich. - Laozi -->
</div>
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Welcome, {{ Auth::user()->name }}!</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
@endsection