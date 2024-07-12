@extends('layout.main')
@section('content')
<div class="row">
        <div class="col-md-6">
            <h3>Customer</h3>
            <input type="text" id="customer" class="form-control" placeholder="Customer Name">
            <h3>Product List</h3>
            <ul id="product-list">
                @foreach($products as $product)
                <li data-id="{{ $product->id_produk }}" data-price="{{ $product->harga }}">
                    {{ $product->nama_produk }} - {{ $product->harga }}
                    <button class="add-to-cart">Add</button>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <h3>Cart</h3>
            <ul id="cart">
                <!-- Items will be added here dynamically -->
            </ul>
            <h3>Total: <span id="total">0</span></h3>
            <button id="checkout">Checkout</button>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const cart = [];
    const productList = document.getElementById('product-list');
    const cartList = document.getElementById('cart');
    const totalElement = document.getElementById('total');

    productList.addEventListener('click', function(event) {
        if (event.target.classList.contains('add-to-cart')) {
            const li = event.target.closest('li');
            const id = li.getAttribute('data-id');
            const price = li.getAttribute('data-price');
            const name = li.textContent.trim().split(' - ')[0];

            const cartItem = cart.find(item => item.id === id);
            if (cartItem) {
                cartItem.quantity += 1;
            } else {
                cart.push({ id, name, price, quantity: 1 });
            }

            renderCart();
        }
    });

    function renderCart() {
        cartList.innerHTML = '';
        let total = 0;

        cart.forEach(item => {
            total += item.price * item.quantity;
            const li = document.createElement('li');
            li.textContent = `${item.name} x ${item.quantity} - ${item.price * item.quantity}`;
            cartList.appendChild(li);
        });

        totalElement.textContent = total;
    }
});
</script>
@endsection
