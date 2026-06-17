@if(session('success'))
    <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-lg">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-lg">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif