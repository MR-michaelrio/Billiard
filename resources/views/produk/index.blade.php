@extends('layout.main')

@section('content')
<style>
    .meja {
        color: black;
        background-color: #72fc89;
        width: auto;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
    }

    .table {
        width: 100%;
        table-layout: fixed;
    }

    .table th {
        width: 20%;
    }

    .countdown {
        font-weight: bold;
        color: red;
    }
</style>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="id_table">Table ID</label>
                            <select class="form-control select2" id='id_table' name='id_table' onchange="myFunction()" style="width: 100%;">
                                <option value='0'>0</option>
                                @foreach($rental as $m)
                                <option value='{{$m->id}}'>{{ $m->no_meja }} | {{ $m->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                <!-- Cart items will be injected here by JavaScript -->
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-danger" id="cancel-button">Cancel</button>
                            </div>
                            <div class="col-6 text-right">
                                <button class="btn btn-primary" id="submit-button">Bayar Langsung</button>
                                <button class="btn btn-secondary" id="save-button" style="display: none;">Simpan</button>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <h3>Total: <span id="total-price">0</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="example3" class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <th>{{ $product['nama_produk'] }}</th>
                                    <th><button class="btn btn-success add-to-cart" data-name="{{ $product['nama_produk'] }}" data-price="{{ $product['harga'] }}">Add</button></th>
                                </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cartItems = [];
        const cartItemsContainer = document.getElementById('cart-items');
        const totalPriceElement = document.getElementById('total-price');

        function updateCart() {
            return new Promise((resolve) => {
                cartItemsContainer.innerHTML = '';
                let totalPrice = 0;
                cartItems.forEach((item, index) => {
                    totalPrice += item.price * item.quantity;
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>
                            <input type="number" class="form-control quantity-input" value="${item.quantity}" data-name="${item.name}">
                        </td>
                        <td>${item.price}</td>
                        <td>
                            <button class="btn btn-danger remove-from-cart" data-index="${index}">Remove</button>
                        </td>
                    `;
                    cartItemsContainer.appendChild(row);
                });
                totalPriceElement.textContent = totalPrice;

                resolve();
            });
        }

        function showAlert2(title, text, icon) {
            return Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'OK'
            });
        }

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function () {
                const name = this.getAttribute('data-name');
                const price = parseFloat(this.getAttribute('data-price'));
                const existingItem = cartItems.find(item => item.name === name);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    cartItems.push({
                        name,
                        price,
                        quantity: 1
                    });
                }
                updateCart();
            });
        });

        document.getElementById('cancel-button').addEventListener('click', function () {
            cartItems.length = 0;
            updateCart();
        });

        document.getElementById('submit-button').addEventListener('click', async function () {
            document.getElementById('loading').style.display = 'flex';

            const idTable = document.getElementById('id_table').value;
            try {
                const response = await fetch('{{ route("orders.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id_table: idTable,
                        items: cartItems
                    })
                });

                const data = await response.json();
                document.getElementById('loading').style.display = 'none';
                console.log("datas: ", data);

                if (data.success) {
                    await showAlert2('Success','Order submitted successfully', 'success');
                    cartItems.length = 0;
                    await updateCart();
                    console.log("order_id", data.order_id);

                    // Redirect to print the receipt using id_rental
                    const printUrl = `{{ route('print.strukorder', ['order_id' => ':order_id']) }}`.replace(':order_id', data.order_id);
                    window.location.href = printUrl;
                } else {
                    showAlert('Error','There was an error submitting the order','error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error','There was an error submitting the order. Please check the console for more details.','error');
            }
        });

        document.getElementById('save-button').addEventListener('click', async function() {
            document.getElementById('loading').style.display = 'flex';

            const idTable = document.getElementById('id_table').value;
            try {
                const response = await fetch('{{ route("orders.store2") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id_table: idTable, items: cartItems })
                });

                const data = await response.json();
                document.getElementById('loading').style.display = 'none';

                if (data.success) {
                    await showAlert('Success','Order saved successfully', 'success');
                    cartItems.length = 0;
                    await updateCart();
                } else {
                    showAlert('Error','There was an error saving the order','error');
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('loading').style.display = 'none';
                showAlert('Error','There was an error saving the order. Please check the console for more details.','error');
            }
        });

        cartItemsContainer.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-from-cart')) {
                const index = parseInt(event.target.getAttribute('data-index'));
                cartItems.splice(index, 1);
                updateCart();
            }
        });

        cartItemsContainer.addEventListener('change', function (event) {
            if (event.target.classList.contains('quantity-input')) {
                const name = event.target.getAttribute('data-name');
                const quantity = parseInt(event.target.value);
                const item = cartItems.find(item => item.name === name);
                if (item) {
                    item.quantity = quantity;
                }
                updateCart();
            }
        });
    });
</script>
@endsection
