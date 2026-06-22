@extends('templates.template')
@section('title', 'Invoice')
@section('content')
    <div class="container mt-5">
        @include('layouts.success_error_message', ['ui' => 'bootstrap'])
        <h1>Invoice</h1>
        <div class="mt-4" style="overflow-x: auto;">
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
                    @foreach($order->orderItems as $item)
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
        </div>
        <div class="d-flex justify-content-end mt-4">
            <div>
                {{-- total order value --}}
                <p class="h4">Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {{-- informasi pembayaran order --}}
                <h2 class="mt-5">Informasi Pembayaran</h2>
                <p><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</p>
                <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d-m-Y H:i:s') }}</p>
                <p><strong>Status Pesanan:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Total Pembayaran:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                {{-- expired payment with countdown --}}
                @if($order->status === 'pending')
                    <p><strong>Batas Waktu Pembayaran:</strong> <span id="countdown"></span></p>
                    <script>
                        // Set the date we're counting down to
                        var countDownDate = new Date("{{ $order->created_at->addHours(6)->format('Y-m-d H:i:s') }}").getTime();

                        // Update the count down every 1 second
                        var x = setInterval(function() {

                            // Get today's date and time
                            var now = new Date().getTime();

                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;

                            // Time calculations for days, hours, minutes and seconds
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            // Display the result in the element with id="countdown"
                            document.getElementById("countdown").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

                            // If the count down is finished, write some text
                            if (distance < 0) {
                                clearInterval(x);
                                document.getElementById("countdown").innerHTML = "EXPIRED";
                            }
                        }, 1000);
                    </script>
                @endif

            </div>
            <div class="col-md-6">
                {{-- User Info --}}
                <h2 class="mt-5">Informasi Pengiriman</h2>
                <p><strong>Nama:</strong> {{ $order->name }}</p>
                <p><strong>Nomor Telepon:</strong> {{ $order->phone }}</p>
                <p><strong>Alamat Pengiriman:</strong> {{ $order->address }}</p>
            </div>
        </div>
        {{-- Button to confirm the order via whatsapp --}}
        @php
            $whatsappMessage = "Halo Admin, saya ingin mengkonfirmasi pesanan dengan nomor pesanan {$order->order_number}. Apakah pesanan saya sudah dibayar?";
            $whatsappLink = "https://wa.me/6281234567890?text=" . urlencode($whatsappMessage);
        @endphp
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ $whatsappLink }}" target="_blank" class="btn btn-success">Konfirmasi Pembayaran via WhatsApp</a>
        </div>
    </div>
@endsection