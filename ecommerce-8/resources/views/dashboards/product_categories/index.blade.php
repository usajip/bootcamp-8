<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Categories') }}
            </h2>
            <a href="{{ route('dashboard.product-categories.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Add Category</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Filter and search form can be added here --}}
                    <div class="flex flex-wrap justify-between gap-2 mb-4">
                        {{-- filter sort by --}}
                        <form action="{{ route('dashboard.product-categories.index') }}" method="GET">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <select name="sort" onchange="this.form.submit()" class="border rounded px-4 py-2">
                                <option value="">Sort by</option>
                                <option value="products_count_desc" {{ request('sort') == 'products_count_desc' ? 'selected' : '' }}>Products Count: High to Low</option>
                                <option value="products_count_asc" {{ request('sort') == 'products_count_asc' ? 'selected' : '' }}>Products Count: Low to High</option>
                                <option value="total_value_desc" {{ request('sort') == 'total_value_desc' ? 'selected' : '' }}>Total Value: High to Low</option>
                                <option value="total_value_asc" {{ request('sort') == 'total_value_asc' ? 'selected' : '' }}>Total Value: Low to High</option>
                                <option value="total_stock_desc" {{ request('sort') == 'total_stock_desc' ? 'selected' : '' }}>Total Stock: High to Low</option>
                                <option value="total_stock_asc" {{ request('sort') == 'total_stock_asc' ? 'selected' : '' }}>Total Stock: Low to High</option>
                            </select>
                        </form>
                        <div class="flex flex-wrap gap-2">
                            {{-- search form --}}
                            <form action="{{ route('dashboard.product-categories.index') }}" method="GET">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                                <input type="text" name="search" placeholder="Search categories..." class="border rounded px-4 py-2" value="{{ request('search') }}">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
                            </form>
                            {{-- reset search --}}
                            @if(request('search') || request('sort'))
                                <a href="{{ route('dashboard.product-categories.index') }}" class="text-white bg-gray-500 px-4 py-2 rounded">Reset</a>
                            @endif
                        </div>
                    </div>
                    {{-- table for displaying product categories --}}
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Slug</th>
                                <th class="px-4 py-2 border">Products Count</th>
                                <th class="px-4 py-2 border">Total Stock</th>
                                <th class="px-4 py-2 border">Total Value</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td class="px-4 py-2 border">{{ $category->id }}</td>
                                <td class="px-4 py-2 border">{{ $category->name }}</td>
                                <td class="px-4 py-2 border">{{ $category->slug }}</td>
                                <td class="px-4 py-2 border">{{ $category->products_count }}</td>
                                <td class="px-4 py-2 border">{{ $category->total_stock }}</td>
                                <td class="px-4 py-2 border">Rp{{ number_format($category->total_value, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 border">
                                    <div class="flex flex-wrap gap-2">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded cursor-pointer">Edit</button>
                                        <button class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded cursor-pointer">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            {{-- More rows can be added here --}}
                        </tbody>
                    </table>
                    {{-- Pagination links can be added here --}}
                    <div class="mt-4">
                        {{ $categories->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
