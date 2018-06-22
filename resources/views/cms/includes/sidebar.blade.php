<ul class="list-group sidebar">
    <a class="center-box list-group-item rounded-0 border-right-0  border-left-0   font-weight-light font-size-1-5
      {{ Request::is('*location*') ? 'active bg-light-primary text-second' : 'bg-third border-gray text-light-primary' }}" href="{{ route('admin.region.index') }}">
        <i class="fa fa-map-marker mr-3 icon"></i>
        Location
        @if(Request::is('*location*'))
        <i class="fa fa-circle float-right text-third center-item right vertical-only-middle font-size-1-2"></i>
        @endif
    </a>
</ul>
