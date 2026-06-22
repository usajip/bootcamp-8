<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">My Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('cart') }}">Cart</a>
        </li>
        @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">Register</a>
        </li>
        @else
          @if(Auth::user()->role === 'admin')
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link" href="{{ route('order.list') }}">Orders</a>
          </li>
        @endguest

        @auth
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to logout?');">
            @csrf
            <button type="submit" class="nav-link btn btn-link">Logout</button> {{-- Use a button to submit the form --}}
          </form>
        </li>
        @endauth
      </ul>
      <form action="{{ route('home') }}" method="GET" role="search" class="d-flex">
          <input type="hidden" name="category" value="{{ request('category') }}">
          <input type="hidden" name="sort" value="{{ request('sort') }}">
          <input type="text" name="search" class="form-control me-2" placeholder="Search products..." aria-label="Search" value="{{ request('search') }}">
          <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>