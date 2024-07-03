@extends('layouts.layout')

@section('pagename', 'Manage Hotels and Types')

@section('header')
@include('layouts.navbarAdmin')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Hotels</h2>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addHotelModal">Add New Hotel</button>
            <ul class="list-group">
                @foreach($hotels as $hotel)
                    <li class="list-group-item">{{ $hotel->name }}</li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <h2>Types</h2>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTypeModal">Add New Type</button>
            <ul class="list-group">
                @foreach($types as $type)
                    <li class="list-group-item">{{ $type->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Add Hotel Modal -->
<div class="modal fade" id="addHotelModal" tabindex="-1" aria-labelledby="addHotelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHotelModalLabel">Add New Hotel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addHotelForm" method="POST" action="{{ route('admin_add_hotels') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="hotelName" class="form-label">Hotel Name</label>
                        <input type="text" class="form-control" id="hotelName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="hotelAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="hotelAddress" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="hotelPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="hotelPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="hotelEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="hotelEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="hotelType" class="form-label">Type</label>
                        <select class="form-select" id="hotelType" name="type_id" required>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Hotel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Type Modal -->
<div class="modal fade" id="addTypeModal" tabindex="-1" aria-labelledby="addTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTypeModalLabel">Add New Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTypeForm" method="POST" action="{{ route('admin_add_type_hotel') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="typeName" class="form-label">Type Name</label>
                        <input type="text" class="form-control" id="typeName" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Type</button>
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
        @if ($errors->has('hotel'))
            $('#addHotelModal').modal('show');
        @elseif ($errors->has('type'))
            $('#addTypeModal').modal('show');
        @endif
    });
</script>
@endsection
