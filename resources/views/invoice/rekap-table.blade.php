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
                        <tr>
                            <td>{{ $rekap['waktu_mulai'] }}</td>
                            <td>{{ $rekap['id_rental'] }}</td>
                            <td>{{ $rekap['lama_waktu'] }}</td>
                            <td>{{ $rekap['no_meja'] }}</td>
                            <td>{{ $rekap['harga_table'] }}</td>
                            <td>{{ $rekap['harga_makanan'] }}</td>
                            <td>{{ $mejatotal }}</td>
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
