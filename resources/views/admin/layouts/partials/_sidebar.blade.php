<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link">
      <img src="{{asset('adminlte')}}/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a><br>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('adminlte')}}/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>-->
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- <li class="nav-item @if(request()->is('admin/sales/*')) menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            @lang('trans.sales')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.sales.create') }}" class="nav-link @if(request()->routeIs('admin.sales.create')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('trans.create_sale')</p>
                            </a>
                        </li>
                     </ul>    --}}
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li> -->
          {{-- users --}}
          <li class="nav-item">
            <a href={{ route('admin.users.index') }} class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                @lang('trans.users')
              </p>
            </a>
          </li>
          {{-- clients --}}
          <li class="nav-item">
            <a href={{ route('admin.clients.index') }} class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                @lang('trans.clients')
              </p>
            </a>
          </li>
          {{-- sales --}}
          <li class="nav-item">
            <a href={{ route('admin.sales.create') }} class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                @lang('trans.sales')
              </p>
            </a>
          </li>
          {{-- categories--}}
          <li class="nav-item">
            <a href={{ route('admin.categories.index') }} class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                @lang('trans.categories')
              </p>
            </a>
          </li>
          {{-- items --}}
          <li class="nav-item">
            <a href={{ route('admin.items.index') }} class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                @lang('trans.items')
              </p>
            </a>
          </li>
          {{-- units--}}
          <li class="nav-item">
            <a href={{ route('admin.units.index') }} class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                 @lang('trans.units')
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
