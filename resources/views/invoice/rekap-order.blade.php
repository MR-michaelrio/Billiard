@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rekap Order Makanan dan Minuman</h3>
            </div>    
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($summarizedOrders as $order)
                        <tr>
                            <td>{{ $order['order_id'] }}</td>
                            <td>{{ number_format($order['total_price'], 0, ',', '.') }}</td>
                            <td>{{ $order['status'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Product Name</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection
