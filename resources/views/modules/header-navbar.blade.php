<?php
$menu_private = array();

//Menu Name, Controller, Method, Uri Parameters, Permission Category
$menu_private = array(
  array(
    'type' => 'menu', 'menu_name' => 'Dashboard', 'route_name' => 'dashboard',
    'controller' => 'HomeController', 'method' => 'index', 'parameters' => '',
    'permission' => '',
    'icon' => '',
  ),

  array(
    'type' => 'menu_list', 'menu_name' => 'Search', 'route_name' => 'support',
    'permission' => '',
    'icon' => '',
    'sub_menu' => array(
      array(
          'type' => 'menu', 'menu_name' => 'Manage Search',
          'controller' => 'Support\SupportController', 'method' => 'index', 'parameters' => '',
          'permission' => '',
          'icon' => '<em class="fa fa-server"></em>'
        ),
      ),
    ),
    array(
      'type' => 'menu_list', 'menu_name' => 'Administration', 'route_name' => 'users',
      'permission' => 'SUPER-USER',
      'icon' => '',
      'sub_menu' => array(
        array(
          'type' => 'menu_list', 'menu_name' => 'User Administration', 'route_name' => 'users',
          'permission' => 'SUPER-USER',
          'icon' => '<em class="fa fa-users"></em>',
          'sub_menu' => array(
            array(
              'type' => 'menu', 'menu_name' => 'Manage Users',
              'controller' => 'Users\UserController', 'method' => 'index', 'parameters' => '',
              'permission' => '',
              'icon' => '<em class="fa fa-list-ul"></em>'
            ),
            array(
              'type' => 'menu', 'menu_name' => 'Create User',
              'controller' => 'Users\UserController', 'method' => 'create', 'parameters' => '',
              'permission' => '',
              'icon' => '<em class="fa fa-user-plus"></em>'
            ),
          ),
        ),
      )
    ),


);
?>
<div class="header d-flex p-0 top-menu" id="headerMenuCollapse">
  <div class="container">
    <div class="row align-items-center">
      <div class="">
        <ul class="nav nav-tabs border-0 flex-nowrap flex-row navbar-expand">
          @foreach($menu_private as $item)
          @if($item['type'] == 'menu')
          @if($item['permission'] == '') 
          <li class="nav-item">
          <a href="{{ isset($item['url']) ? url($item['url']) : action($item['controller'].'@'.$item['method'], $item['parameters']) }}" 
                      @if(isset($item['url'])) target="_blank" @endif
                      class="dropdown-item {{ $item['controller'] == \Request::route()->getName() ? 'active' : '' }}">
                      @if(isset($item['icon']) && $item['icon'] != '')
                      <?php echo $item['icon']; ?>
                      @endif
                      {{ $item['menu_name'] }}
              </a>
          </li>
          @endif
          @elseif($item['type'] == 'menu_list')
          @if($item['permission'] == '')
          <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="nav-link {{ $item['route_name'] == Route::currentRouteName() ? 'active' : '' }}" data-toggle="dropdown" data-submenu="">{{ $item['menu_name'] }} <em class="fe fe-chevron-down"></em></a>
            <div class="dropdown-menu dropdown-menu-arrow">
              @foreach($item['sub_menu'] as $sub_menu)
              @if($sub_menu['type'] == 'menu')
              @if($sub_menu['permission'] == '')
              <a href="{{ isset($sub_menu['url']) ? url($sub_menu['url']) : action($sub_menu['controller'].'@'.$sub_menu['method'], $sub_menu['parameters']) }}" 
                      @if(isset($sub_menu['url'])) target="_blank" @endif
                      class="dropdown-item {{ $sub_menu['controller'] == \Request::route()->getName() ? 'active' : '' }}">
                      @if(isset($sub_menu['icon']) && $sub_menu['icon'] != '')
                      <?php echo $sub_menu['icon']; ?>
                      @endif
                      {{ $sub_menu['menu_name'] }}
              </a>
              @endif
              @endif
              @if($sub_menu['type'] == 'menu_list')
              <div class="dropdown dropdown-submenu dropright">
                <a class="dropdown-item dropdown-toggle" data-toggle="dropdown">
                  @if(isset($sub_menu['icon']) && $sub_menu['icon'] != '')
                  <?php echo $sub_menu['icon']; ?>
                  @endif
                  {{ $sub_menu['menu_name'] }}
                </a>
                <div class="dropdown-menu">
                  @foreach($sub_menu['sub_menu'] as $sub_menu2)
                  @if($sub_menu2['type'] == 'menu')
                  @if($sub_menu2['permission'] == '')
                  <a href="{{ isset($sub_menu2['url']) ? url($sub_menu2['url']) : action($sub_menu2['controller'].'@'.$sub_menu2['method'], $sub_menu2['parameters']) }}" 
                     @if(isset($sub_menu2['url'])) target="_blank" @endif
                     class="dropdown-item {{ $sub_menu2['controller'] == \Request::route()->getName() ? 'active' : '' }}">
                    @if(isset($sub_menu2['icon']) && $sub_menu2['icon'] != '')
                    <?php echo $sub_menu2['icon']; ?>
                    @endif
                    {{ $sub_menu2['menu_name'] }}
                  </a>
                  @endif
                  @endif
                  @endforeach
                </div>
              </div>
              @endif
              @if($sub_menu['type'] == 'menu_divider' && ($sub_menu['permission'] == '' ))
              <div class="dropdown-divider"></div>
              @endif
              @endforeach
            </div>
          </li>
          @elseif($item['type'] == 'menu_divider')
          <div class="dropdown-divider"></div>
          @endif
          @endif
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('[data-submenu]').submenupicker();
  });
</script>
