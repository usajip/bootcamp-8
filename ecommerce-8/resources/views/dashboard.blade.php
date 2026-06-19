<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    @foreach($totals_data as $data)
                        <div class="p-4 rounded-lg flex items-center gap-4" style="background-color: {!! $data['color'] !!};">
                            <span class="material-icons text-4xl" style="color: {!! $data['icon_color'] !!}">{{ $data['icon'] }}</span>
                            <div>
                                <h3>{{ $data['name'] }}</h3>
                                <h2 class="text-3xl font-bold">{{ $data['total'] }}</h2>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 {{ $total_7_days_order_data > 0 ? '' : 'hidden' }}">
                {{-- Chart.js canvas for weekly order data: total order and total revenue --}}
                <div class="mt-6">
                    <canvas id="weeklyOrderChart"></canvas>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- table view of orders data --}}
                <div class="mt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold mb-4">Recent Orders</h2>
                        <a href="{{ route('dashboard.orders.index') }}" class="text-blue-500 hover:underline">View All Orders</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Order ID</th>
                                    <th class="py-2 px-4 border-b">Customer Name</th>
                                    <th class="py-2 px-4 border-b">Total Amount</th>
                                    <th class="py-2 px-4 border-b">Status</th>
                                    <th class="py-2 px-4 border-b">Order Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($recent_orders as $order)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $order->order_number }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->status }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-2 px-4 border-b text-center">No recent orders found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <style>
        /* table head bg */
        table thead {
            background-color: rgb(174, 196, 239);
        }
        /* table zebra striping */
        table tbody tr:nth-child(odd) {
            background-color: #d9ebfd;
        }
    </style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js" integrity="sha256-SERKgtTty1vsDxll+qzd4Y2cF9swY9BCq62i9wXJ9Uo=" crossorigin="anonymous"></script>
<script>
    const rupiahFormatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    });
    let weeklyOrderData = @json($weekly_order_data);
    let ctx = document.getElementById('weeklyOrderChart').getContext('2d');
    let weeklyOrderChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: weeklyOrderData.map(data => data.date),
            datasets: [
                {
                    label: 'Total Orders',
                    data: weeklyOrderData.map(data => data.total_order),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0)',
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y'
                },
                {
                    label: 'Total Revenue',
                    data: weeklyOrderData.map(data => data.total_revenue),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0)',
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Weekly Orders and Revenue'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                if (context.dataset.yAxisID === 'y1') {
                                    label += rupiahFormatter.format(context.parsed.y);
                                } else {
                                    label += context.parsed.y;
                                }
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                'y': {
                    title: {
                        display: true,
                        text: 'Amount'
                    },
                    beginAtZero: true
                },
                'y1': {
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Revenue',
                    },
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false
                    },
                    ticks: {
                        callback: function(value) {
                            return rupiahFormatter.format(value);
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
</x-app-layout>
