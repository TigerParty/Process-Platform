@if ($breadcrumbs)
<nav aria-label="breadcrumb" >
  <ol class="breadcrumb mb-2  mt-3 rounded-0 bg-white box-shadow">
    @foreach ($breadcrumbs as $breadcrumb)
       @if (!$loop->last)
            <li class="breadcrumb-item"><a class="text-black" href="{{ $breadcrumb->url }}"> {{ $breadcrumb->title }}</a></li>
        @else
            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb->title }}</li>
        @endif
    @endforeach
  </ol>
</nav>
@endif