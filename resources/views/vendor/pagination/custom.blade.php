@if ($paginator->hasPages())
    <nav class="pagination-nav">
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&laquo; Previous</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Previous</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li class="page-number"><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next &raquo;</a></li>
            @else
                <li class="disabled"><span>Next &raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
