@props(['paginator'])

@if(isset($paginator) && $paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-4">
    <div class="text-sm text-gray-600" aria-live="polite">
        Mostrando <span class="font-medium">{{ $paginator->firstItem() }}</span>–<span class="font-medium">{{ $paginator->lastItem() }}</span> de <span class="font-medium">{{ $paginator->total() }}</span>
    </div>

    <div>
        {!! $paginator->appends(request()->query())->links() !!}
    </div>
</nav>
@endif