@extends('layouts.layout')

@section('pagename', 'User Transactions')

@section('header')
@include('layouts.navbarAdmin')
@endsection

@section('content')
<div class="container">
    <h2>User Transactions</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>

                    <td>{{ $transaction->invoice }}</td>
                    <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    <td>
                        <button class="btn btn-info btn-detail" data-bs-toggle="modal" data-bs-target="#detailModal" data-transaction-id="{{ $transaction->id }}">Detail</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="transactionDetails">
                    <!-- Transaction details will be populated here -->
                </div>
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
        $('.btn-detail').click(function() {
            const transactionId = $(this).data('transaction-id');
            fetchTransactionDetails(transactionId);
        });

        function fetchTransactionDetails(transactionId) {
            $.ajax({
                url: '{{ route("admin_transaction_details") }}',
                method: 'GET',
                data: { id: transactionId },
                success: function(response) {
                    console.log(response)
                    const transactionDetails = generateTransactionDetailsHTML(response.transaction, response.reservations);
                    $('#transactionDetails').html(transactionDetails);
                },
                error: function(response) {
                    $('#transactionDetails').html('<p class="text-danger">'+response.message+'</p>');
                }
            });
        }

        function generateTransactionDetailsHTML(transaction, reservations) {
            console.log(transaction, reservations)
            let html = `<h5>Transaction: ${transaction.invoice}</h5>`;
            html += `<p>Total Price: Rp ${new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(transaction.total_price)}</p>`;

            if (reservations.length === 0) {
                html += '<p>No reservations found for this transaction.</p>';
            } else {
                html += '<table class="table table-striped"><thead><tr><th>Hotel</th><th>Product</th><th>Price</th></tr></thead><tbody>';
                reservations.forEach(reservation => {
                    const total = reservation.quantity * reservation.product.price;
                    html += `<tr>
                                <td>${reservation.product.hotel.name}</td>
                                <td>${reservation.product.name}</td>
                                <td>Rp ${new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(reservation.product.price)}</td>
                             </tr>`;
                });
                html += '</tbody></table>';
            }

            return html;
        }
    });
</script>
@endsection
