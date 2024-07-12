@extends('layout.main')
@section('content')
<style>
    .meja {
        color: black;
        width: auto;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
    }

    .meja-green {
        background-color: #72fc89;
    }

    .meja-yellow {
        background-color: #ffd666;
    }

    .meja-red {
        background-color: #ff6666;
    }

    .countdown {
        font-weight: bold;
        color: red;
        text-align: center;
        font-size: 24px;
    }

    .card {
        margin-bottom: 20px;
    }
</style>
<div class="row">
    @foreach($meja_rental as $mi)
    <div class="col-12 col-md-4 col-lg-3">
        <div class="card">
            <a href="{{ route('bl.menu', $mi['nomor_meja']) }}">
                <div class="card-body">
                    <div class="meja {{ $mi['waktu_akhir'] ? 'meja-yellow' : 'meja-green' }}" data-end-time="{{ $mi['waktu_akhir'] }}">
                        Meja {{ $mi['nomor_meja'] }}
                    </div>
                    <div class="countdown">{{ $mi['waktu_akhir'] }}</div>
                </div>
            </a>
        </div>
    </div>
    @endforeach
</div>

<script>
    function startCountdown(element, endTime) {
        function updateCountdown() {
            const now = new Date().getTime();
            const endTimeMillis = new Date(endTime).getTime();
            const timeRemaining = endTimeMillis - now;

            if (timeRemaining <= 0) {
                element.querySelector('.countdown').innerHTML = "00:00:00";
                element.querySelector('.meja').classList.remove('meja-yellow');
                element.querySelector('.meja').classList.add('meja-red');
                return;
            }

            const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            element.querySelector('.countdown').innerHTML =
                `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const countdownElements = document.querySelectorAll('.countdown');
        countdownElements.forEach(element => {
            const endTimeString = element.closest('.card-body').querySelector('.meja').getAttribute('data-end-time');
            if (endTimeString) {
                startCountdown(element.closest('.card-body'), endTimeString);
            }
        });
    });
</script>
@endsection
