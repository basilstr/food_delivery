<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach($menu as $item)
            @if(isset($item))
                @if(isset($item['items']))
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon {{ $item['icon'] }}"></i>
                            <p>
                                {{ $item['title'] }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                        @foreach($item['items'] as $sub_item)
                                @if(isset($sub_item))
                                    <li class="nav-item">
                                        <a href="{{ $sub_item['route'] }}" class="nav-link @if($sub_item['active']) active @endif">
                                            <i class="nav-icon {{ $sub_item['icon'] }}"></i>
                                            <p>{{ $sub_item['title'] }}</p>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ $item['route'] }}" class="nav-link">
                            <i class="nav-icon {{ $item['icon'] }}"></i>
                            <p>
                                {{ $item['title'] }}
                            </p>
                        </a>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
</nav>
