@extends('templates.template')

@section('title', $title)

@section('content')
    <div class="container mt-5">
        <h1>Welcome to the {{ $title }}</h1>
        <p>This is the home page of the ecommerce-8 application.</p>

        <div class="flex-row d-flex flex-wrap gap-3">
            @forelse($products as $product)
            {{-- <div class="col-md-2"> --}}
                <x-product-card 
                    title="{{ $product['title'] }}" 
                    description="{{ $product['description'] }}" 
                    image="{{ asset('images/' . $product['image']) }}" 
                    link="{{ route('detail-product', ['id' => $product['id']]) }}"
                />
            {{-- </div> --}}
            @empty
                <p>No products available.</p>
            @endforelse
        </div>
    </div>
@endsection