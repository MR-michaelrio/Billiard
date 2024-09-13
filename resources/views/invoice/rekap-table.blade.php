@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rekap Order</h3>
            </div>    
            <!-- /.card-headerasd -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Rental ID</th>
                            <th>No Meja</th>
                            <th>Lama Waktu</th>
                            <th>Harga Table</th>
                            <th>Harga Makanan</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $id_rental => $rekap)
                        <tr>
                            <td>{{ $id_rental }}</td>
                            <td>{{ $id_rental }}</td>
                            <td>{{ $rekap['no_meja'] }}</td>
                            <td>{{ $rekap['lama_waktu'] }}</td>
                            <td>{{ number_format($rekap['mejatotal'], 2) }}</td>
                            <td>{{ number_format($rekap['total_makanan'], 2) }}</td>
                            <td>{{ number_format($rekap['total'], 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Tanggal</th>
                            <th>Rental ID</th>
                            <th>No Meja</th>
                            <th>Lama Waktu</th>
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
