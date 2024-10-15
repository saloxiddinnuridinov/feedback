
@if ($paginator->hasPages())
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <a href="#">&laquo;</a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <a href="#">{{ $element }}</a>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="#" class="active">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
        @else
            <a href="#">&raquo;</a>
        @endif
    </div>
@endif
