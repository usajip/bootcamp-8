@extends('templates.template')

@section('title', $product['title'])

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('images/' . $product['image']) }}" alt="{{ $product['title'] }}" class="img-fluid mb-3">
            </div>
            <div class="col-md-6">
                <h1>{{ $product['title'] }}</h1>
                <p>{{ $product['description'] }}</p>
                <p class="h4 text-primary">Price: Rp{{ number_format($product['price'], 0, ',', '.') }}</p>
                <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Home</a>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <h3>Related Products</h3>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($recommendation_products as $related)
                        <x-product-card 
                            title="{{ $related['title'] }}" 
                            description="{{ $related['description'] }}" 
                            image="{{ asset('images/' . $related['image']) }}" 
                            link="{{ route('detail-product', ['id' => $related['id']]) }}"
                        />
                    @endforeach
                </div>
            </div>
    </div>
@endsection