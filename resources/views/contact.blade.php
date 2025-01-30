<div>
    <!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
</div>
@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
@section('content')
<div class="contact-container">
    <h2>Contact Us</h2>
    <form id="contactForm" method="POST" action="{{ route('contact.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" class="form-control" placeholder="Write your message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</div>
@endsection
