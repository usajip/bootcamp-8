@extends('templates.template')

@section('title', $product->name)

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid w-100 mb-3 rounded">
            </div>
            <div class="col-md-6">
                <h6>{{ $product->category->name }}</h6>
                <h1>{{ $product->name }}</h1>
                <p>{{ $product->description }}</p>
                <p class="h4 text-primary">Price: Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Home</a>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <h3>Related Products</h3>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($related_products as $related)
                        <x-product-card 
                            title="{{ $related->name }}" 
                            description="{{ $related->description }}" 
                            image="{{ asset('images/' . $related->image) }}" 
                            link="{{ route('detail-product', ['slug' => $related->slug]) }}"
                            category="{{ $related->category->name }}"
                            price="{{ $related->price }}"
                        />
                    @endforeach
                </div>
            </div>
    </div>
@endsection