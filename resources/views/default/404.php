@extends('layouts.app')

<div class="d-flex text-center flex-column justify-content-center mt-5">
    <h2 class="w-100">404 - Page Not Found</h2>
    <p class="mt-3">Sorry, the page you are looking for does not exist.</p>
    <div class="d-flex justify-content-center">
        <button onclick="window.history.back()" class="btn btn-outline-warning mt-3 w-25">Go back</button>
    </div>
    <div class="d-flex justify-content-center">
        <a href="{{ route('home') }}" class="btn btn-outline-warning mt-3 w-25">Go to Home</a>
    </div>
</div>
