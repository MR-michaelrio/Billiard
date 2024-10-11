@extends('layout.main')
@section('content')
<div class="row">
    <a href="{{ route('bl.menunonmember', $no_meja) }}" class="btn btn-block btn-primary btn-lg">Non Member</a>
    <!-- <a href="{{ route('bl.menumember', $no_meja) }}" class="btn btn-block btn-primary btn-lg">Member</a> -->
    <button class="btn btn-block btn-primary btn-lg btn-stop" data-nomor-meja="{{ $no_meja }}">Stop</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nomorMeja = "{{ $no_meja }}"; // Get nomor meja from Blade
        const stopwatchKey = `stopwatch_${nomorMeja}`;

        // Check if start time exists in localStorage, if not set it
        if (!localStorage.getItem(stopwatchKey)) {
            const currentTime = new Date().getTime();
            localStorage.setItem(stopwatchKey, currentTime); // Set start time
        }

        // Event listener for Stop button
        document.querySelector('.btn-stop').addEventListener('click', function () {
            const startTime = localStorage.getItem(stopwatchKey);
            
            if (startTime) {
                const currentTime = new Date().getTime();
                const elapsedTime = currentTime - startTime;

                // Convert elapsedTime to seconds
                const elapsedSeconds = Math.floor(elapsedTime / 1000);

                // Redirect to the stop page with nomor meja and elapsed time
                window.location.href = `/stop/${nomorMeja}?elapsed=${elapsedSeconds}`;
            } else {
                console.error("Start time not found in localStorage");
            }
        });
    });
</script>
@endsection
