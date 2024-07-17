@extends('layout.main')
@section('content')
<div class="row">
    <a href="{{ route('bl.menunonmember', $no_meja) }}" class="btn btn-block btn-primary btn-lg">Non Member</a>
    <a href="{{ route('bl.menumember', $no_meja) }}" class="btn btn-block btn-primary btn-lg">Member</a>
    <button class="btn btn-block btn-primary btn-lg btn-stop" data-nomor-meja="{{ $no_meja }}">Stop</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tambahkan event listener untuk tombol stop
        document.querySelectorAll('.btn-stop').forEach(button => {
            button.addEventListener('click', function () {
                const nomorMeja = this.getAttribute('data-nomor-meja');
                const stopwatchKey = `stopwatch_${nomorMeja}`;
                const startTime = localStorage.getItem(stopwatchKey);
                const currentTime = new Date().getTime();
                const elapsedTime = currentTime - startTime;

                // Konversi elapsedTime ke detik
                const elapsedSeconds = Math.floor(elapsedTime / 1000);

                // Redirect ke halaman stop dengan nomor meja dan waktu yang telah berlalu
                window.location.href = `/stop/${nomorMeja}?elapsed=${elapsedSeconds}`;
            });
        });
    });
</script>
@endsection
