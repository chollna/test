@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Access Denied</h2>
    <p>Your IP address ({{ request()->ip() }}) is not allowed to access this page.</p>
</div>
@endsection
