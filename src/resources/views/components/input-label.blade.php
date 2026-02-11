@props(['value'])

<label {{ $attributes->merge(['class' => 'app-form-label']) }}>
    {{ $value ?? $slot }}
</label>
