@extends('layouts.layout')

@section('pagename')
    Admin Dashboard
@endsection

@section('header')
@include('layouts.navbarAdmin')
@endsection

@section('content')
    <div class="container mt-5">
        <h2>Top Pelanggan</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Reservations Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topCustomers as $index => $customer)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->reservations_count }}</td>
                        <td>
                            <button class="btn btn-info detail-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-type="customer" data-id="{{ $customer->id }}">Details</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Top Hotels</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Reservations Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topHotels as $index => $hotel)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $hotel->name }}</td>
                        <td>{{ $hotel->reservations_count }}</td>
                        <td>
                            <button class="btn btn-info detail-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-type="hotel" data-id="{{ $hotel->id }}">Details</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Top Products</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Reservations Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topProducts as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->reservations_count }}</td>
                        <td>
                            <button class="btn btn-info detail-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-type="product" data-id="{{ $product->id }}">Details</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Reservations in the Last Week</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Hotel Name</th>
                    <th>Product Name</th>
                    <th>Date and Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $index => $reservation)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->product->hotel->name }}</td>
                        <td>{{ $reservation->product->name }}</td>
                        <td>{{ $reservation->tanggal_jam }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailModalBody">
                    <!-- Details will be loaded here via JavaScript -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.detail-btn').click(function() {
                var type = $(this).data('type');
                var id = $(this).data('id');
                var url = '';
                switch (type) {
                    case 'customer':
                        url = '{{ route('admin_customer_details', ':id') }}'.replace(':id', id);
                        break;
                    case 'hotel':
                        url = '{{ route('admin_hotel_details', ':id') }}'.replace(':id', id);
                        break;
                    case 'product':
                        url = '{{ route('admin_produk_details', ':id') }}'.replace(':id', id);
                        break;
                    default:
                        return;
                }
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        var content = '';
                        console.log(response);
                        switch (type) {
                            case 'customer':
                                content += '<h4>' + response.customer.name + '</h4>';
                                content += '<ul>';
                                $.each(response.reservations, function(index, reservation) {
                                    content += '<li>' + reservation.product.name +
                                        ' at ' + reservation.product.hotel.name +
                                        ' - ' + reservation.tanggal_jam + '</li>';
                                });
                                content += '</ul>';
                                break;
                            case 'hotel':
                                content += '<h4>' + response.hotel.name + '</h4>';
                                content += '<ul>';
                                $.each(response.reservations, function(index, reservation) {
                                    content += '<li>' + reservation.user.name +
                                        ' reserved ' + reservation.product.name +
                                        ' - ' + reservation.tanggal_jam + '</li>';
                                });
                                content += '</ul>';
                                break;
                            case 'product':
                                content += '<h4>' + response.product.name + '</h4>';
                                content += '<ul>';
                                $.each(response.reservations, function(index, reservation) {
                                    content += '<li>' + reservation.user.name + ' - ' +
                                        reservation.tanggal_jam + '</li>';
                                    content += '<p>Hotel: ' + reservation.product.hotel
                                        .name + '</p>';
                                });
                                content += '</ul>';
                                break;
                        }

                        $('#detailModalBody').html(content);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endsection
