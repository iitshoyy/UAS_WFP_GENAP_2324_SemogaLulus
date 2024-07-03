@extends('layouts.layout')

@section('pagename', 'Products and Product Types')

@section('header')
@include('layouts.navbarAdmin')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Products</h2>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Facilities</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->productType->name }}</td>
                            <td>{{ $product->nama_fasilitas }}</td>
                            <td>{{ $product->deskripsi_fasilitas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h2>Product Types</h2>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductTypeModal">Add Product Type</button>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productTypes as $productType)
                        <tr>
                            <td>{{ $productType->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="productPrice" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label for="productType" class="form-label">Product Type</label>
                        <select class="form-control" id="productType" name="product_type_id" required>
                            @foreach($productTypes as $productType)
                                <option value="{{ $productType->id }}">{{ $productType->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="hotel" class="form-label">Hotel</label>
                        <select class="form-control" id="hotel" name="hotel_id" required>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productFacilities" class="form-label">Facilities</label>
                        <input type="text" class="form-control" id="productFacilities" name="nama_fasilitas" required>
                    </div>
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="productDescription" name="deskripsi_fasilitas" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Type Modal -->
<div class="modal fade" id="addProductTypeModal" tabindex="-1" aria-labelledby="addProductTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductTypeModalLabel">Add Product Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('product-types.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="productTypeName" class="form-label">Product Type Name</label>
                        <input type="text" class="form-control" id="productTypeName" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product Type</button>
                </form>
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
        @if($errors->any())
            @if($errors->has('product_name'))
                $('#addProductModal').modal('show');
            @elseif($errors->has('product_type_name'))
                $('#addProductTypeModal').modal('show');
            @endif
        @endif
    });
</script>
@endsection
