@extends('layouts.layout')

@section('pagename', 'Hotel List')

@section('dependencies')
    <!-- Bootstrap CSS is already included in the layout -->
@endsection

@section('header')
@include('layouts.navbar')
@endsection

@section('content')
<div class="container">
    <div class="row">
        @foreach($hotels as $hotel)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{'https://via.placeholder.com/300x200.png?text='.$hotel->name}}" class="card-img-top" alt="Hotel Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $hotel->name }}</h5>
                        <p class="card-text">{{ $hotel->address }}</p>
                        <p class="card-text">{{ $hotel->email }}</p>
                        <a href="{{ route('hotel_detail', $hotel->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
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
    // Add any custom JavaScript here
</script>
@endsection
