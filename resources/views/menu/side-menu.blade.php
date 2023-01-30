<!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-heading">Main Menu</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/blank') }}">
          <i class="bi bi-grid"></i>
          <span>Blank Page</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Example</span><i class="bi bi-chevron-down ms-auto"></i>
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


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#project-management" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark"></i><span>Project Management</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="project-management" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('project.management.master')}}">
              <i class="bi bi-circle"></i><span>Project Master</span>
            </a>
          </li>
          <li>
            <a href="{{route('project.management.master.product')}}">
              <i class="bi bi-circle"></i><span>Product Master</span>
            </a>
          </li>
          <li>
            <a href="{{route('project.management.master.part')}}">
              <i class="bi bi-circle"></i><span>Part Master</span>
            </a>
          </li>
          <li>
            <a href="{{route('project.management.master.listcheck')}}">
              <i class="bi bi-circle"></i><span>List Check Master</span>
            </a>
          </li>
          <li>
            <a href="{{route('project.management.upload.project')}}">
              <i class="bi bi-circle"></i><span>Upload Project Doc</span>
            </a>
          </li>
          <li>
            <a href="{{route('project.management.master.part')}}">
              <i class="bi bi-circle"></i><span>Check Eng Doc</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#schedule-delivery" data-bs-toggle="collapse" href="#">
          <i class="bi bi-truck"></i><span>Delivery Schedule</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="schedule-delivery" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('delivery.schedule.mf')}}">
              <i class="bi bi-circle"></i><span>Download Manifest Order</span>
            </a>
          </li>
          <li>
            <a href="{{route('delivery.schedule.spc')}}">
              <i class="bi bi-circle"></i><span>Download Spc Order</span>
            </a>
          </li><li>
            <a href="{{route('monitoring.delivery')}}">
              <i class="bi bi-circle"></i><span>Monitoring Delivery</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#doc-iso" data-bs-toggle="collapse" href="#">
          <i class="bi bi-truck"></i><span>Doc Iso</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="doc-iso" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <!-- <a href="{{route('delivery.schedule.mf')}}"> -->
            <a href="{{ url('/doc-iso/master-notify') }}">
              <i class="bi bi-circle"></i><span>Master Notify</span>
            </a>
          </li>
          <li>
            <a href="{{ route('doc-iso.register-iso') }}">
            <!-- <a href ="data_table.php"> -->
              <i class="bi bi-circle"></i><span>Register ISO Doc</span>
            </a>
          </li>
          <li>
            <a href="{{ url('/doc-iso/master-notify/report-iso') }}">
            <!-- <a href ="data_table.php"> -->
              <i class="bi bi-circle"></i><span>Report ISO Doc</span>
            </a>
          </li>
          <li>
            <a href="{{ route('doc-iso.dashboard-iso') }}">
            <!-- <a href ="data_table.php"> -->
              <i class="bi bi-circle"></i><span>Dashboard ISO Doc</span>
            </a>
          </li>
        </ul>
      </li>

      
      
    </ul>

  </aside><!-- End Sidebar-->