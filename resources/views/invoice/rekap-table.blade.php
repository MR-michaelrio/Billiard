@extends('layout.main')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rekap Order</h3>
            </div>    
            <div id="token-form" class="card-header">
                <h3 class="card-title">Enter Access Token</h3>
                <form id="tokenForm">
                    @csrf
                    <div class="form-group">
                        <label for="token">Token:</label>
                        <input type="text" class="form-control" id="token" name="token" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <!-- /.card-headerasd -->
            <div class="card-body" id="rekap-table-container" style="display:none;">
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
                    @foreach($data as $rekap)
                        <tr>
                            <td>{{ $rekap['tanggal'] }}</td>
                            <td>{{ $rekap['id_rental'] }}</td>
                            <td>{{ $rekap['no_meja'] }}</td>
                            <td>{{ $rekap['lama_waktu'] }}</td>
                            <td>{{ number_format($rekap['mejatotal']) }}</td>
                            <td>{{ number_format($rekap['total_makanan']) }}</td>
                            <td>{{ number_format($rekap['total']) }}</td>
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

<script>
    document.getElementById('tokenForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent form from submitting traditionally

        const token = document.getElementById('token').value;
        const validToken = "068924"; // Define the valid token

        // Check if the token is correct
        if (token === validToken) {
            // Hide the token form and show the table
            document.getElementById('token-form').style.display = 'none';
            document.getElementById('rekap-table-container').style.display = 'block';
        } else {
            alert('Invalid Token! Please try again.');
        }
    });
</script>
@endsection
