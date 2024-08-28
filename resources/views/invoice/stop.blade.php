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
                        Billiard.
                        <small class="float-right">Date: {{ now()->format('d-m-Y') }}</small>
                    </h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            @foreach($meja_rental2 as $r)
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <b>Order ID:</b> {{$r->id}}<br>
                        <b>Table:</b> {{$r->no_meja}}<br>
                        <b>Payment Due:</b> {{ now()->format('d-m-Y') }}<br>
                        <b>Account:</b> {{$r->id_player}}
                    </div>
                    <!-- /.col -->
                </div>
            @endforeach

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Product</th>
                                <th>QTY</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($meja_rental2 as $r)
                            <tr>
                                <td>1</td>
                                <td>Meja Billiard</td>
                                <td><span id="lama_waktu">{{$lama_waktu}}</span></td>
                                <td>{{number_format($mejatotal)}}</td>
                            </tr>
                        @endforeach
                        @php 
                            $no = 2;
                        @endphp 
                        @foreach($makanan as $order)
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Total:</th>
                                    <td>{{$total}}</td>
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
                @foreach($meja_rental2 as $r)
                    <button type="button" class="submit-button btn btn-success float-right" data-meja="{{$r->no_meja}}">
                        Submit Payment
                    </button>
                @endforeach

                </div>
            </div>
        </div>
        <!-- /.invoice -->
    </div>
</div>

<script>
document.querySelectorAll('.submit-button').forEach(button => {
    button.addEventListener('click', function() {
        const noMeja = this.getAttribute('data-meja');
        const lamaWaktu = document.getElementById('lama_waktu').textContent;

        console.log('Sending request with noMeja:', noMeja, 'lamaWaktu:', lamaWaktu);

        fetch('{{ route("bl.bayar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ no_meja: noMeja, lama_waktu: lamaWaktu })
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                return response.json().then(error => { throw new Error(error.message || 'Unknown error'); });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                resetStopwatch(data.no_meja);
                alert('Order submitted successfully');
                // Redirect to print the receipt
                const printUrl = `{{ route('print.receipt', ['id_rental' => ':id_rental']) }}`.replace(':id_rental', data.id_rental);
                window.location.href = printUrl;        
            } else {
                alert('There was an error submitting the order: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error submitting the order. Please check the console for more details.');
        });
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
