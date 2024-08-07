@extends('layout.main')
@section('content')

@foreach($invoices as $p)
    @php
        $id_player = $p->id_player;
        $lama_waktu = $p->lama_waktu;
        $waktu_mulai = $p->waktu_mulai;
        $waktu_akhir = $p->waktu_akhir;
        $no_meja = $p->no_meja;
    @endphp
@endforeach

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <li>Id Member: {{$id_player}}</li>
                    <li>Lama Waktu: {{$lama_waktu}}</li>
                    <li>Waktu Mulai: {{$waktu_mulai}}</li>
                    <li>Waktu Akhir: {{$waktu_akhir}}</li>
                    <li>No Meja: {{$no_meja}}</li>
                </h3>
            </div>               
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Makanan dan Minuman</th>
                            <th>QTY</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $p)
                        <tr>
                            <td>{{$p->product_name}}</td>
                            <td>{{$p->quantity}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Makanan dan Minuman</th>
                            <th>QTY</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection
