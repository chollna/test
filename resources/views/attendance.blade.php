
<div class="container">
    <h2>Clock In / Clock Out</h2>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card p-4">
        <p><strong>Your IP Address:</strong> {{ request()->ip() }}</p>

        <form method="POST" action="{{ route('clock.in') }}">
            @csrf
            <button type="submit" class="btn btn-success">Clock In</button>
        </form>

        <form method="POST" action="{{ route('clock.out') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-danger">Clock Out</button>
        </form>
    </div>
</div>
