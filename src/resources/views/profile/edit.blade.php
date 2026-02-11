@php
    $cardStyle = 'p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg';
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="app-container-lg space-y-6">
        <div class="{{ $cardStyle }}">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="{{ $cardStyle }}">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="{{ $cardStyle }}">
            <div class="max-w-xl">
                @include('profile.partials.push-form')
            </div>
        </div>

        <div class="{{ $cardStyle }}">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
