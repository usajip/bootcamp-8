@extends('templates.template')

@section('title', $title)

@section('content')
    <div class="container mt-5">
        <h1>Welcome to the {{ $title }}</h1>
        <p>This is the home page of the ecommerce-8 application.</p>
        {{-- product category filter will go here and search bar --}}
            {{-- Category filter with select option --}}
        <form action="{{ route('home') }}" method="GET" role="search" class="d-flex justify-content-between align-items-center mb-3">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <div class="form-group">
                <label for="category" class="form-label">Filter by Category:</label>
                <select name="category" id="category" class="form-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Sort By Price --}}
            <div class="form-group">
                <label for="sort" class="form-label">Sort by Price:</label>
                <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Default</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Low to High</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>High to Low</option>
                    <option value="best_seller" {{ request('sort') == 'best_seller' ? 'selected' : '' }}>Best Seller</option>
                </select>
            </div>
        </form>

        <div class="flex-row d-flex flex-wrap align-items-center justify-content-center gap-3 mb-3">
            @forelse($products as $item)
            {{-- <div class="col-md-2"> --}}
                <x-product-card 
                    title="{{ $item->name }}" 
                    description="{{ $item->description }}" 
                    image="{{ asset('images/' . $item->image) }}" 
                    link="{{ route('detail-product', ['slug' => $item->slug]) }}"
                    category="{{ $item->category->name }}"
                    price="{{ $item->price }}"
                />
            {{-- </div> --}}
            @empty
                <p>No products available.</p>
            @endforelse
        </div>
        {{ $products->links('pagination::bootstrap-5')  }}
    </div>
@endsection