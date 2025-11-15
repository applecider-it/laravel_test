@if($errors->any())
    <div class="bg-red-100 p-2 rounded mb-4">
        {{ $input_error_message ?? '入力に問題があります' }}
    </div>
@endif
