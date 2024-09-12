@extends('layout.main')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rekap Table</h3>
            </div>    
            <!-- /.card-header -->
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-warning">
                        {{ $errors->first() }}
                    </div>
                @endif
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Hari Tanggal</th>
                            <th>Rental ID</th>
                            <th>Lama Waktu</th>
                            <th>No Meja</th>
                            <th>Harga Table</th>
                            <th>Harga Makanan</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($rentalinvoice as $rekap)
    @php
        // Calculate 'lama_waktu'
        $lama_waktu = $rekap->lama_waktu ?? '00:00:00';

        // Parse 'lama_waktu' into hours, minutes, and seconds
        list($hours, $minutes, $seconds) = sscanf($lama_waktu, '%d:%d:%d');
        $total_minutes = $hours * 60 + $minutes + $seconds / 60;

        // Calculate meja (table) price based on duration and per-minute rate
        $harga_per_menit = $rekap->harga_per_menit ?? 0; // Ensure a default of 0 if no price is set
        $mejatotal = $total_minutes * $harga_per_menit;

        // Check for the best price from package deals
        $best_price = null;
        foreach ($paket as $p) {
            if ($lama_waktu == $p->jam) {
                $best_price = $p->harga;
                break;
            }
        }
        // Use the package price if available, otherwise the calculated per-minute price
        $mejatotal = $best_price !== null ? $best_price : $mejatotal;

        // If no valid table price is found, it should remain as 0 rupiah
        // No fallback is applied here, so if there's no valid price, mejatotal remains 0.

        // Calculate the total food price
        $orderMakanan = $makanan[$rekap->id_rental] ?? collect(); // Safely access makanan
        $total_makanan = $orderMakanan->flatMap(function($order) {
            return $order->items;
        })->sum(function($item) {
            return $item->price * $item->quantity;
        });

        // Ensure total_makanan is 0 if no food is purchased
        if ($total_makanan == 0 || $orderMakanan->isEmpty()) {
            $total_makanan = 0;
        }

        // Calculate total (table price + food price)
        $total = $mejatotal + $total_makanan;
        $total = round($total, 2); // Round total to 2 decimal places

    @endphp

    <tr>
        <td>{{ $rekap->waktu_mulai }}</td>
        <td>{{ $rekap->id_rental }}</td>
        <td>{{ $lama_waktu }}</td>
        <td>{{ $rekap->no_meja }}</td>
        <td>{{ number_format($mejatotal, 2) }}</td> <!-- Table price -->
        <td>{{ number_format($total_makanan, 2) }}</td> <!-- Food price -->
        <td>{{ number_format($total, 2) }}</td> <!-- Total price -->
    </tr>
@endforeach


                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Hari Tanggal</th>
                            <th>Rental ID</th>
                            <th>Lama Waktu</th>
                            <th>No Meja</th>
                            <th>Harga Table</th>
                            <th>Harga Makanan</th>
                            <th>Total Harga</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection
