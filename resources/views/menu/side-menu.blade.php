<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-heading">Main Menu</li>
      <!-- EXAMPLE -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/blank') }}">
          <i class="bi bi-grid"></i>
          <span>Blank Page</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ url('/component/forminput') }}">
              <i class="bi bi-circle"></i><span>Form Input</span>
            </a>
          </li>
          <li>
            <a href="{{ url('/component/datatable') }}">
              <i class="bi bi-circle"></i><span>DataTable</span>
            </a>
          </li>
        </ul>
      </li>

       <!-- END EXAMPLE -->

      @foreach(Session::get('permissions') as $menu)
        @if($menu['children']!=null)
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#{{$menu['name']}}" data-bs-toggle="collapse" href="{{ url($menu['url']) }}">
            <i class="{{$menu['icon']}}"></i><span>{{$menu['name']}}</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="{{$menu['name']}}" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            @foreach($menu['children'] as $sub)
            <li>
              <a href="{{ url($sub['url']) }}">
                <i class="bi bi-circle"></i><span>{{$sub['name']}}</span>
              </a>
            </li>
            @endforeach
          </ul>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{ url($menu['url']) }}">
            <i class="{{$menu['icon']}}"></i>
            <span>{{$menu['name']}}</span>
          </a>
        </li>
        @endif
      @endforeach
  </ul>
</aside><!-- End Sidebar-->
