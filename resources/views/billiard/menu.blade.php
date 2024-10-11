@extends('layout.main')
@section('content')
<div class="row">
    <a href="{{ route('bl.menunonmember', $no_meja) }}" class="btn btn-block btn-primary btn-lg">Non Member</a>
    <button class="btn btn-block btn-primary btn-lg btn-stop" data-nomor-meja="{{ $no_meja }}">Stop</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nomorMeja = "{{ $no_meja }}"; // Get nomor meja from Blade
        const stopwatchKey = `stopwatch_${nomorMeja}`;

        // Reset localStorage (optional, only for testing, you can comment this after testing)
        // localStorage.removeItem(stopwatchKey);

        // Check if start time exists in localStorage, if not set it
        if (!localStorage.getItem(stopwatchKey)) {
            const currentTime = new Date().getTime();
            localStorage.setItem(stopwatchKey, currentTime); // Set start time
        } else {
            console.log("Start time found in localStorage:", localStorage.getItem(stopwatchKey));
        }

        // Function to format time in HH:MM:SS
        function formatTime(seconds) {
            const hrs = Math.floor(seconds / 3600).toString().padStart(2, '0'); // Calculate hours
            const mins = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0'); // Calculate minutes
            const secs = (seconds % 60).toString().padStart(2, '0'); // Calculate seconds
            return `${hrs}:${mins}:${secs}`;
        }

        // Event listener for Stop button
        document.querySelector('.btn-stop').addEventListener('click', function () {
            const startTime = localStorage.getItem(stopwatchKey);
            
            if (startTime) {
                const currentTime = new Date().getTime();
                const elapsedTime = currentTime - parseInt(startTime); // Convert startTime from string to integer

                // Convert elapsedTime from milliseconds to seconds
                const elapsedSeconds = Math.floor(elapsedTime / 1000);

                // Format elapsedSeconds to HH:MM:SS
                const formattedTime = formatTime(elapsedSeconds);

                // Output formatted time (replace console.log with appropriate DOM manipulation if needed)
                console.log("Elapsed time:", formattedTime);
                
                // Uncomment the line below to redirect with elapsed time in seconds (if needed)
                // window.location.href = `/stop/${nomorMeja}?elapsed=${elapsedSeconds}`;
            } else {
                console.error("Start time not found in localStorage");
            }
        });
    });
</script>
@endsection
