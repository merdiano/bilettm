<div class="pagination_blk">
    <span>@lang('ClientSide.search_showing') - {{$paginator->count()}}/{{$paginator->total()}}</span>
@if ($paginator->hasPages())
        <ul class="pagination" role="navigation">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <img src="{{asset('assets/images/icons/left.png')}}">
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><img src="{{asset('assets/images/icons/left.png')}}"></a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><img src="{{asset('assets/images/icons/right.png')}}"></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <img src="{{asset('assets/images/icons/right.png')}}">
                </li>
            @endif
        </ul>
@endif
</div>
