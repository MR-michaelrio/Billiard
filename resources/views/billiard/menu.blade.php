@extends('layout.main')
@section('content')
<div class="row">
    <a href="{{ route('bl.menunonmember', $no_meja) }}" class="btn btn-block btn-primary btn-lg">Non Member</a>
    <button class="btn btn-block btn-primary btn-lg btn-stop" data-nomor-meja="{{ $no_meja }}">Stop</button>
</div>

<script>
    // Start the stopwatch with the correct start time (from DB if available)
    function startStopwatch(element, startTime) {
        const stopwatchKey = `stopwatch_${element.closest('.card-body').querySelector('.meja').getAttribute('data-nomor-meja')}`;
        const start = startTime ? new Date(startTime).getTime() : new Date().getTime(); // Use database startTime if available
        if (!startTime) {
            localStorage.setItem(stopwatchKey, start); // Save start time in localStorage if not provided from DB
        }

        function updateStopwatch() {
            const now = new Date().getTime();
            const elapsed = now - start; // Calculate elapsed time from start time

            const hours = Math.floor((elapsed % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((elapsed % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((elapsed % (1000 * 60)) / 1000);

            element.querySelector('.stopwatch').innerHTML = 
                `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        updateStopwatch();
        setInterval(updateStopwatch, 1000); // Update the stopwatch every second
    }

    document.addEventListener('DOMContentLoaded', function () {
        const timerElements = document.querySelectorAll('.stopwatch');
        timerElements.forEach(element => {
            const status = element.getAttribute('data-status');
            const nomorMeja = element.closest('.card-body').querySelector('.meja').getAttribute('data-nomor-meja');
            if (status === 'lanjut') {
                const startTime = element.closest('.card-body').querySelector('.meja').getAttribute('data-start-time');
                startStopwatch(element.closest('.card-body'), startTime); // Pass the database start time to the stopwatch
            }
        });

        // Add event listener for stop button
        document.querySelectorAll('.btn-stop').forEach(button => {
            button.addEventListener('click', function () {
                const nomorMeja = this.getAttribute('data-nomor-meja');
                const stopwatchKey = `stopwatch_${nomorMeja}`;
                const startTime = localStorage.getItem(stopwatchKey);
                const currentTime = new Date().getTime();
                const elapsedTime = currentTime - startTime;

                // Convert elapsedTime to seconds
                const elapsedSeconds = Math.floor(elapsedTime / 1000);

                // Redirect to the stop page with table number and elapsed time
                window.location.href = `/stop/${nomorMeja}?elapsed=${elapsedSeconds}`;
            });
        });
    });
</script>
@endsection
