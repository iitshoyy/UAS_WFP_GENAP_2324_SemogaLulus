<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
    <a class="navbar-brand" href="#">LaraLux</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin_dashboard')}}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin_hotels')}}">Hotels</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin_produk')}}">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin_transactions')}}">Transactions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('customers.index')}}">User</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            @if (Auth::check())
            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>

            @else
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                </li>
            @endif
        </ul>
    </div>
</nav>
