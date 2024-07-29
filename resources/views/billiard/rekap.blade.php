@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Members</h3>
            </div>               
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id Member</th>
                            <th>Lama Waktu</th>
                            <th>No Meja</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $p)
                        <tr>
                            <td>{{$p->id_player}}</td>
                            <td>{{$p->rentalinvoice->lama_waktu}}</td>
                            <td>{{$p->rentalinvoice->no_meja}}</td>
                            <td>
                                <a href="{{ route('bl.showrekap', $p->id) }}" class="btn btn-primary">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id Member</th>
                            <th>Lama Waktu</th>
                            <th>No Meja</th>
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
