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
        // Calculate 'lama_waktu' and 'mejatotal' for each row
        $lama_waktu = $rekap->lama_waktu ?? '00:00:00';

        // Parse 'lama_waktu' into hours, minutes, and seconds
        list($hours, $minutes, $seconds) = sscanf($lama_waktu, '%d:%d:%d');
        $total_minutes = $hours * 60 + $minutes + $seconds / 60;

        // Use the per-minute pricing from the rental model
        $harga_per_menit = $rekap->harga_per_menit ?? 0;
        $mejatotal = $total_minutes * $harga_per_menit;

        // Check if a package matches the duration
        $best_price = null;
        foreach ($paket as $p) {
            if ($lama_waktu == $p->jam) {
                $best_price = $p->harga;
                break;
            }
        }
        // Use package price if found, else the per-minute price
        $mejatotal = $best_price !== null ? $best_price : $mejatotal;
    @endphp

    <tr>
        <td>{{ $rekap->waktu_mulai }}</td>
        <td>{{ $rekap->id_rental }}</td>
        <td>{{ $lama_waktu }}</td>
        <td>{{ $rekap->no_meja }}</td>
        <td>{{ $rekap->harga_table }}</td>
        <td>{{ $rekap->harga_makanan }}</td>
        <td>{{ number_format($mejatotal, 2) }}</td> <!-- Format the total to 2 decimal places -->
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
