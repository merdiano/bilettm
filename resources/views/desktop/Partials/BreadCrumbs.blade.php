@if (count($breadcrumbs))
<section class="page-breadcrumbs">
    <div class="container">
        <div class="row">
            <ul style="padding-left: 15px" class="breadcrumbs-ul">
                @foreach ($breadcrumbs as $breadcrumb)
                    @if ($breadcrumb->url && !$loop->last)
                        <li style="text-transform: capitalize">
                            <a style="text-transform: capitalize" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                        </li>
                        <li>
                            <i class="fa fa-caret-right"></i>
                        </li>
                    @else
                        <li class="page-name" style="color: #7f7f7f; text-transform: capitalize">
                            {{ $breadcrumb->title }}
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endif