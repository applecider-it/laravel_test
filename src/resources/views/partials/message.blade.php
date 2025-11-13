@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 p-2 rounded mb-4">
        {{ $input_error_message ?? '入力に問題があります' }}
    </div>
@endif
