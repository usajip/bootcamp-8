@php
$no_navbar = true;
@endphp
@extends('templates.template')
@section('title', 'Checkout')
@section('content')
    <div class="container mt-5">
        <h1>Checkout</h1>
        {{-- Cart Items --}}
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart_items as $item)
                            <tr>
                                <td><img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid" style="max-width: 100px;"></td>
                                <td>{{ $item->product->name }}</td>
                                <td>Rp{{ number_format($item->product->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mt-4">
                    <div>
                        {{-- total active cart value --}}
                        <p class="h4">Total: Rp{{ number_format($cart_items->sum(function($item) { return $item->product->price * $item->quantity; }), 0, ',', '.') }}</p>
                    </div>
                </div>
                {{-- User Info completion name, phone, address --}}
                <h2 class="mt-5">Informasi Pengiriman</h2>
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Pengiriman</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required>{{ $user->address ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Bayar Sekarang</button>
                </form>
                
            @endif
        </div>
    </div>
@endsection