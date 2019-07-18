
@if ($paginator->lastPage() > 1)
    <nav aria-label="...">
        <ul class="pagination justify-content-center pagination-sm">
            <li class="page-item font-weight-bold ">
                <a class="page-link " href="{{ $paginator->url(1)}}">|<</a>
            </li>
            <li class="page-item font-weight-bold {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                <a class="page-link " href="{{ $paginator->url($paginator->currentPage()-1)}}"><<</a>
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @if($paginator->currentPage() == $i)
                    @if($i>1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($i-1) }}">{{ $i-1 }}</a>
                        </li>
                    @endif
                    <li class="page-item active">
                        <span class="page-link">
                            {{ $i }}
                            <span class="sr-only">(current)</span>
                        </span>
                    </li>
                    @if($i<$paginator->lastPage())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($i+1) }}">{{ $i+1 }}</a>
                        </li>
                    @endif
                @endIf
            @endfor
            <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                <a class="page-link font-weight-bold" href="{{ $paginator->url($paginator->currentPage()+1) }}" >>></a>
            </li>
            <li class="page-item font-weight-bold ">
                <a class="page-link " href="{{ $paginator->url($paginator->lastPage())}}">>|</a>
            </li>
        </ul>
    </nav>
@endif