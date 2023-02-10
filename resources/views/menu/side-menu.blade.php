<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-heading">Main Menu</li>

      @foreach(Session::get('permissions') as $menu)
        @if(!empty($menu['children']))
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#{{str_replace(' ', '', $menu['name'])}}" data-bs-toggle="collapse" href="{{ url($menu['url']) }}">
              <i class="{{$menu['icon']}}"></i><span>{{$menu['name']}}</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="{{ str_replace(' ', '', $menu['name']) }}" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              @foreach($menu['children'] as $sub)
              <li>
                <a href="{{ url($sub['url']) }}">
                  <i class="bi bi-circle"></i><span>{{$sub['name']}}</span>
                </a>
              </li>
              @endforeach
            </ul>
          </li>
        {{-- @else
          <li class="nav-item">
            <a class="nav-link collapsed" href="#">
              <i class=""></i>
              <span></span>
            </a>
          </li> --}}
        @endif
      @endforeach
  </ul>
</aside><!-- End Sidebar-->
