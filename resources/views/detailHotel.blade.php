@extends('layouts.layout')

@section('pagename', $hotel->name . ' - Details')

@section('header')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>{{ $hotel->name }} - Products</h2>
            <form id="reservationForm" method="POST" action="{{ route('pelanggan_reservasi') }}">
                @csrf
                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                <div class="row">
                    @foreach($products as $key => $product)
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div></div>
                                <img src="{{'https://via.placeholder.com/300x200.png?text='.$product->name}}" class="card-img-top" alt="Product Image">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <div class=""></div>
                                    <p class="card-text">Type: {{ $product->productType->name }}</p>
                                    <p class="card-text">Price: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <input type="number" class="form-control quantity" name="quantities[{{ $product->id }}]" data-price="{{ $product->price }}" data-product="{{ $product->name }}" min="0" max="10" value="{{ old('quantities.' . $product->id, 0) }}" placeholder="Quantity">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="reservasiButton" class="btn btn-primary">Reservasi</button>
            </form>
        </div>
        <div class="col-md-4">
            @if ($errors->any())
                @foreach ($errors->all() as $pesanError)
                    <div class="alert alert-danger">{{ $pesanError }}</div>
                @endforeach
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
                @php
                    Session::forget('success');
                @endphp
            @elseif (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @php
                    Session::forget('error');
                @endphp
            @endif
            <h2>Invoice Details</h2>
            <div id="invoice">
                <p>Subtotal: Rp <span id="subtotal">0,00</span></p>
                <p>Fee (11%): Rp <span id="fee">0,00</span></p>
                <p>Total: Rp <span id="total">0,00</span></p>
                <ul id="invoice-details"></ul>
            </div>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <p class="mt-2">Don't have an account? <a href="#" id="showRegisterForm">Register here</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="register-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="register-password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <p class="mt-2">Already have an account? <a href="#" id="showLoginForm">Login here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<footer class="text-center">
    <p>&copy; 2024 Hotel List. All Rights Reserved.</p>
</footer>
@endsection

@section('js_script')
<script>
    $(document).ready(function() {
        const quantityInputs = $('.quantity');
        const subtotalElement = $('#subtotal');
        const feeElement = $('#fee');
        const totalElement = $('#total');
        const invoiceDetails = $('#invoice-details');
        const reservasiButton = $('#reservasiButton');
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));

        $('#showRegisterForm').click(function(e) {
            e.preventDefault();
            loginModal.hide();
            registerModal.show();
        });

        $('#showLoginForm').click(function(e) {
            e.preventDefault();
            registerModal.hide();
            loginModal.show();
        });

        reservasiButton.click(function() {
            @guest
                loginModal.show();
            @else
                // Submit the reservation form
                $('#reservationForm').submit();
            @endguest
        });

        quantityInputs.on('input', function() {
            updateInvoice();
        });

        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount).replace('IDR', 'Rp').trim();
        }

        function updateInvoice() {
            let subtotal = 0;
            invoiceDetails.empty();

            quantityInputs.each(function() {
                const quantity = parseInt($(this).val()) || 0;
                const price = parseFloat($(this).data('price'));
                const product = $(this).data('product');

                if (quantity > 0) {
                    const cost = quantity * price;
                    subtotal += cost;

                    const detailItem = $('<li></li>').text(`${product} - ${quantity} x ${formatRupiah(price)} = ${formatRupiah(cost)}`);
                    invoiceDetails.append(detailItem);
                }
            });

            const fee = subtotal * 0.11;
            const total = subtotal + fee;

            subtotalElement.text(formatRupiah(subtotal));
            feeElement.text(formatRupiah(fee));
            totalElement.text(formatRupiah(total));
        }
    });
</script>
@endsection
