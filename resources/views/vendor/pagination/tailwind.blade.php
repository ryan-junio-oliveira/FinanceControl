@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        <div class="flex gap-2 items-center justify-between sm:hidden">

            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 cursor-not-allowed leading-5 rounded-md dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-800 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-700 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-800 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-gray-200">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-800 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-700 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-800 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-gray-200">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 cursor-not-allowed leading-5 rounded-md dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600">
                    {!! __('pagination.next') !!}
                </span>
            @endif

        </div>

        <div class="hidden sm:flex sm:items-center sm:justify-center">

            <div>
                <span class="inline-flex rtl:flex-row-reverse shadow-sm rounded-md">

                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}"
                              class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-400 bg-neutral-primary-soft border border-default cursor-not-allowed">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                           class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading transition-colors focus:outline-none focus:ring-2 focus:ring-cyan-400/40"
                           aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                        </a>
                    @endif

                    {{-- Page numbers --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="inline-flex items-center justify-center w-9 h-9 text-sm text-gray-400 select-none">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page"
                                          class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-sm font-semibold text-white bg-cyan-700 border border-cyan-700 cursor-default shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-sm text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading transition-colors focus:outline-none focus:ring-2 focus:ring-cyan-400/40"
                                       aria-label="{{ __('Ir para página :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                           class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-body bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium hover:text-heading transition-colors focus:outline-none focus:ring-2 focus:ring-cyan-400/40"
                           aria-label="{{ __('pagination.next') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}"
                              class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-400 bg-neutral-primary-soft border border-default cursor-not-allowed">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
