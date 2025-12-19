@if ($paginator->hasPages())
    <div class="pagination-wrap">
        <ul>

            {{-- PREV --}}
            @if ($paginator->onFirstPage())
                <li>
                    <a class="disabled">Prev</a>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}">Prev</a>
                </li>
            @endif

            {{-- PAGE NUMBERS --}}
            @foreach ($elements as $element)

                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <a class="disabled">{{ $element }}</a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            <a href="{{ $url }}"
                               class="{{ $page == $paginator->currentPage() ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach
                @endif

            @endforeach

            {{-- NEXT --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}">Next</a>
                </li>
            @else
                <li>
                    <a class="disabled">Next</a>
                </li>
            @endif

        </ul>
    </div>
@endif
