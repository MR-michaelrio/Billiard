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
                                <td>{{$rental}}</td>
                                <td>Meja Billiard {{$r->lama_waktu}}</td>
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
                    <!-- <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                            class="fas fa-print"></i> Print</a> -->
                    <form action="{{route('bl.bayar')}}" method="post">
                        @csrf
                        @foreach($meja_rental as $r)
                            <button type="submit" name='bayar' value='{{$r->no_meja}}' class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                                Payment
                            </button>
                        @endforeach
                    </form>
                    <!-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                        <i class="fas fa-download"></i> Generate PDF
                    </button> -->
                </div>
            </div>
        </div>
        <!-- /.invoice -->
    </div>
</div>
@endsection
