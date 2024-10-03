@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rekap Detail Bulanan</h3>
            </div>               
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Jumlah Invoice</th>
                            <th>Total Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($rekaps as $invoice)
                        <tr>
                            <td>{{ $invoice->month }}</td>
                            <td>{{ $invoice->rentalinvoice->no_meja }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Jumlah Invoice</th>
                            <th>Total Jumlah</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection
