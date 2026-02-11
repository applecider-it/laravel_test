@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'app-error-text']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
