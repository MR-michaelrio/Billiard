@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-12">
        <!-- Main content -->
        <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-globe"></i> AdminLTE, Inc.
                        <small class="float-right">Date: {{ now()->format('d-m-Y') }}</small>
                    </h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            @foreach($meja_rental as $r)
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <b>Order ID:</b> {{$r->id}}<br>
                        <b>Payment Due:</b> {{ now()->format('d-m-Y') }}<br>
                        <b>Account:</b> {{$r->id_player}}
                    </div>
                    <!-- /.col -->
                </div>
            @endforeach

            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Product</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($meja_rental as $r)
                            <tr>
                                <td>1</td>
                                <td>Meja Billiard <span id="lama_waktu">{{$lama_waktu}}</span></td>
                                <td>$64.50</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <!-- /.col -->
                <div class="col-6">
                    <p class="lead">Amount Due {{ now()->format('d-m-Y') }}</p>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td>$250.30</td>
                                </tr>
                                <tr>
                                    <th>Tax (9.3%)</th>
                                    <td>$10.34</td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td>$5.80</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>$265.24</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-12">
                    @foreach($meja_rental as $r)
                        <button type="button" id="submit-button" name='bayar' value='{{$r->no_meja}}' class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                            Payment
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- /.invoice -->
    </div>
</div>

<script>
document.getElementById('submit-button').addEventListener('click', function() {
    const noMeja = this.value;
    const lamaWaktu = document.getElementById('lama_waktu').textContent; // Ambil lama_waktu dari elemen dengan ID lama_waktu

    fetch('{{ route("bl.bayar") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ no_meja: noMeja, lama_waktu: lamaWaktu })
    })
    .then(response => {
        console.log('Response status:', response.status); // Log status response
        if (!response.ok) {
            return response.json().then(error => { throw new Error(error.error); });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            resetStopwatch(data.no_meja);
            alert('Order submitted successfully');
            window.location.href = '{{ route("bl.index") }}';
        } else {
            alert('There was an error submitting the order: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error submitting the order. Please check the console for more details.');
    });
});

function resetStopwatch(noMeja) {
    const stopwatchKey = `stopwatch_${noMeja}`;
    localStorage.removeItem(stopwatchKey);

    const element = document.querySelector(`.meja[data-nomor-meja="${noMeja}"]`);
    if (element) {
        const stopwatchElement = element.closest('.card-body').querySelector('.stopwatch');
        if (stopwatchElement) {
            stopwatchElement.innerHTML = '00:00:00';
        }
        element.classList.remove('meja-yellow', 'meja-red');
        element.classList.add('meja-green');
    }
}
</script>
@endsection
