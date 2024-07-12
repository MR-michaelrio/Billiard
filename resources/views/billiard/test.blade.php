@extends('layout.main')
@section('content')
<style>
    .meja {
        color: black;
        background-color: #72fc89;
        width: auto;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
    }

    .table {
        width: 100%;
        table-layout: fixed;
    }

    .table th {
        width: 20%;
    }

    .countdown {
        font-weight: bold;
        color: red;
    }
</style>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    @foreach($meja_invoices as $mi)
                        <th>
                            <a href="{{ route('bl.create', $mi['nomor_meja']) }}">
                                <div class="meja">
                                    Meja {{ $mi['nomor_meja'] }}
                                </div>
                            </a>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($meja_invoices as $mi)
                        <td>
                            <div class="countdown" data-end-time="{{ $mi['waktu_akhir'] }}">{{ $mi['waktu_akhir'] }}</div>
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function startCountdown(element, endTime) {
        function updateCountdown() {
            const now = new Date().getTime();
            const endTimeMillis = new Date(endTime).getTime();
            const timeRemaining = endTimeMillis - now;

            if (timeRemaining <= 0) {
                element.innerHTML = "00:00:00";
                return;
            }

            const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            element.innerHTML = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const countdownElements = document.querySelectorAll('.countdown');
        console.log("Found countdown elements:", countdownElements);
        countdownElements.forEach(element => {
            const endTimeString = element.getAttribute('data-end-time');
            console.log("Countdown element end time:", endTimeString);
            if (endTimeString) {
                startCountdown(element, endTimeString);
            }
        });
    });
</script>
@endsection
