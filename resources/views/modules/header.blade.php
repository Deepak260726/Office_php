<script>

// Toastr - Error Global Method
function triggerToastrError (message) {
  toastr.error(message, {
        preventDuplicates: true,
        progressBar: true,
        timeOut: 5000,
        extendedTimeOut: 3000
      });
};

// Toastr - Suucess Global Method
function triggerToastrSuccess (message) {
  toastr.success(message, {
        preventDuplicates: true,
        progressBar: true,
        timeOut: 5000,
        extendedTimeOut: 3000
      });
};

// Toastr - Warning Global Method
function triggerToastrWarning (message) {
  toastr.warning(message, {
        preventDuplicates: true,
        progressBar: true,
        timeOut: 5000,
        extendedTimeOut: 3000
      });
};


// Toastr - Info Global Method
function triggerToastrInfo (message) {
  toastr.info(message, {
        preventDuplicates: true,
        progressBar: true,
        timeOut: 5000,
        extendedTimeOut: 3000
      });
};

  $(document).ready(function() {

      // Enable all Tooltip
    $(function () {
      $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
      })
    });

    // Enable all Popover
    $(function () {
      $('[data-toggle="popover"]').popover({
        container: 'body'
      });
    });



  });
</script>
@if(!\App::environment('production'))
  <div class="bg-warning-new text-white text-center">
    << {{ strtoupper(\App::environment()) }} >>
  </div>
@endif
<div class="header py-0">
  <div class="container-fluid" style="max-width:1330px;">
    <div class="d-flex">
      <a class="header-brand py-3" href="{{ url('') }}">
        
      </a>

      <!-- Header Navbar -->
      @if(\Auth::check())
        @include('modules.header-navbar')
      @EndIf

      <!-- Header UserProfile Menu -->
      @if(\Auth::check())
        <div class="d-flex order-lg-2 ml-auto py-3">
          <div class="dropdown">
            <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
              <div id="profileImage" class="w-2r bdrs-50p bgc-pink-500">{{ substr(Auth::user()->first_name, 0, 1) }}</div>
              <span class="ml-2 d-none d-lg-block">
                <span class="text-default">{{ Auth::user()->first_name}} <em class="fe fe-chevron-down"></em> </span>

              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <a class="dropdown-item" href="#">
                <em class="dropdown-icon fe fe-user"></em> Profile
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <em class="dropdown-icon fe fe-help-circle"></em> Need help?
              </a>
              <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <em class="dropdown-icon fe fe-log-out"></em> Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </div>
        </div>
        <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
          <span class="header-toggler-icon"></span>
        </a>
      @EndIf
    </div>
  </div>
</div>
