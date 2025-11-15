@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        @include('vendor.pagination.tailwind.responsive')

        @include('vendor.pagination.tailwind.primary')
    </nav>
@endif
