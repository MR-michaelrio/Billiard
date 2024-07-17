@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>Meja {{$no_meja}}</h1>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Non Member</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('bl.storenonmember')}}" method="post">
                @csrf
                <input type="hidden" value="{{$no_meja}}" name="no_meja" class="form-control">
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name='nama' placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="No_Telp">Nomor Telp</label>
                        <input type="text" class="form-control" id="No_Telp" name='no_telp' placeholder="08.......">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
