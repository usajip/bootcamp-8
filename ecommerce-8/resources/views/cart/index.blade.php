@extends('templates.template')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="container mt-5">
        <div class="row">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center justify-content-between">
                    <div>{{ session('success') }}</div>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @elseif(session('errors'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach(session('errors')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <h1>Keranjang Belanja</h1>
                <p>Ini adalah halaman keranjang belanja ecommerce-8.</p>
                <div class="mt-4" style="overflow-x: auto;">
                    @if($cart_items->isEmpty())
                        <p>Keranjang belanja Anda kosong.</p>
                    @else
                        <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart_items as $item)
                                    <tr>
                                        <td><img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid" style="max-width: 100px;"></td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>Rp{{ number_format($item->product->price, 0, ',', '.') }}</td>
                                        <td>
                                            <form action="{{ route('cart.update', ['id' => $item->id]) }}" method="POST" class="d-flex align-items-center gap-2">
                                                @csrf
                                                <div class="input-group" style="width: 120px;">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity({{ $item->id }})">-</button>
                                                    <input type="text" class="form-control text-center" max="{{ $item->product->stock }}" name="quantity" value="{{ $item->quantity }}" id="quantity-input-{{ $item->id }}">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity({{ $item->id }})">+</button>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </td>
                                        <td>Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                                        <td>
                                            <form action="{{ route('cart.remove', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <div>
                        {{-- total active cart value --}}
                        <p class="h4">Total: Rp{{ number_format($cart_items->sum(function($item) { return $item->product->price * $item->quantity; }), 0, ',', '.') }}</p>
                        <a href="{{ route('checkout') }}" class="btn btn-success {{ $cart_items->isEmpty() ? 'disabled' : '' }}">Checkout</a>
                    </div>
                </div>
            </div>
            {{-- Cart Items with 0 stock --}}
            @if(!$cart_items_sold->isEmpty())
                <div class="mt-4" style="overflow-x: auto;">
                    <h4>Produk yang sudah habis</h4>
                    <table class="table table-bordered table-sold" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart_items_sold as $item)
                                <tr>
                                    <td><img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid" style="max-width: 100px;filter: grayscale(100%);"></td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>Rp{{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', ['id' => $item->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@push('styles')
<style>
    .table-sold {
        opacity: 0.6;
    }
</style>
@endpush
@push('scripts')
<script>
    function decreaseQuantity(id) {
        const input = document.getElementById(`quantity-input-${id}`);
        let currentValue = parseInt(input.value);
        if(currentValue > 1){
            input.value = currentValue - 1;
        }
    }

    function increaseQuantity(id) {
        const input = document.getElementById(`quantity-input-${id}`);
        let currentValue = parseInt(input.value);
        const maxValue = parseInt(input.getAttribute('max'));
        if(currentValue < maxValue){
            input.value = currentValue + 1;
        }
    }
</script>
@endpush
@endsection