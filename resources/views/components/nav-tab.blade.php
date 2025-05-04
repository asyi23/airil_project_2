<div class="d-md-flex align-items-center justify-content-between nav-tab">
    <ul class="nav nav-tabs nav-tabs-custom col-12" role="tablist">
        @if ($type == 'ads')
            @foreach ($routeList as $route)
                <li class="nav-item">
                    <a class="nav-link @if($route['route_name'] == $currentRoute['route_name']) active @endif" href="{{ $route['route'] }}" role="tab">{{ $route['name'] }} @if(@$pendingList[$route['type_id']] > 0) <span class="badge badge-pill badge-warning ">{{ $lead_pending[$route['type_id']] }}</span>@endif</a>
                </li>
            @endforeach
        @elseif ($type == 'setting')
            @foreach ($routeList as $route)
                <li class="nav-item">
                    <a class="nav-link @if($route['active']) active @endif" href="{{ $route['route'] }}" role="tab">{{ $route['name'] }} @if(@$pendingList[$route['type_id']] > 0) <span class="badge badge-pill badge-warning ">{{ $lead_pending[$route['type_id']] }}</span>@endif</a>
                </li>
            @endforeach
        @endif
    </ul>
</div>