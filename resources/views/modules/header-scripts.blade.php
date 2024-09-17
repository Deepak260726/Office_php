    <!-- AWS RUM -->
    @include('modules.header-aws-rum')
    
    <!-- Require JS -->
    <!-- <script src="{{ asset('/js/require.min.js') }}"></script>
    <script>
      requirejs.config({
          baseUrl: 'http://localhost/eSupportV2/public/'
      });
    </script>-->

    <!-- JQuery -->
    <script src="{{ asset('/js/vendors/jquery-3.2.1.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('/js/vendors/bootstrap.bundle.min.js') }}"></script>

    <!-- Dashboard Core -->
    <link href="{{ asset('/css/dashboard-20220829.css') }}" rel="stylesheet" />
    <!-- <script src="{{ asset('/js/dashboard.js') }}"></script> -->

    <!-- Bootstrap Navbar -->
    <link href="{{ asset('/plugins/bootstrap-multi-level-menu/bootstrap-4-navbar.css') }}" rel="stylesheet" />

    <!-- Flags -->
    <link href="{{ asset('/plugins/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet" />

    <!-- c3.js Charts Plugin -->
    <!--<link href="{{ asset('/plugins/charts-c3/plugin.css') }}" rel="stylesheet" />
    <script src="{{ asset('/plugins/charts-c3/plugin.js') }}"></script>-->

    <!-- Google Maps Plugin -->
    <!--<link href="{{ asset('/plugins/maps-google/plugin.css') }}" rel="stylesheet" />
    <script src="{{ asset('/plugins/maps-google/plugin.js') }}"></script>-->

    <!-- Input Mask Plugin -->
    <!--<script src="{{ asset('/plugins/input-mask/plugin.js') }}"></script>-->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/css/font-awesome-5.min.css') }}">

    <!-- Data Tables -->
    <link href="{{ asset('/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <script src="{{ asset('/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/datatables/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/datatables/Buttons-1.5.2/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/datatables/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/datatables/Buttons-1.5.2/js/buttons.colVis.min.js') }}"></script>
    <link href="{{ asset('/datatables/Buttons-1.5.2/css/buttons.bootstrap4.css') }}" rel="stylesheet" />

    <!-- JQuery Validation : https://jqueryvalidation.org/ -->
    <script src="{{ asset('/js/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/js/validation/additional-methods.min.js') }}"></script>

    <!-- Toaster -->
    <link href="{{ asset('/plugins/toastr/toastr.css') }}" rel="stylesheet" />
    <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

    <!--BlockUI-->
    <script src="{{ asset('/plugins/blockUI/jquery.blockUI.js') }}"></script>

    <!--selectize -->
    <script src="{{ asset('/plugins/selectize/selectize.min.js') }}"></script>

    <!-- Select2 -->
    <link href="{{ asset('/plugins/select2/select2.css') }}" rel="stylesheet" />
    <script src="{{ asset('/plugins/select2/select2.full.js') }}"></script>

    <!-- iCheck -->
    <link href="{{ asset('/plugins/iCheck/skins/all.css') }}" rel="stylesheet" />
    <script src="{{ asset('/plugins/iCheck/icheck.js') }}"></script>

    <!-- DateTime Picker -->
    <link href="{{ asset('/plugins/datetimepicker/bootstrap-datetimepicker.css') }}" rel="stylesheet" />
    <script src="{{ asset('/plugins/datetimepicker/moment.js') }}"></script>
    <script src="{{ asset('/plugins/datetimepicker/bootstrap-datetimepicker.js') }}"></script>

    <script src="{{ asset('/plugins/bootstrap-multi-level-menu/bootstrap-4-navbar.js') }}"></script>

    <!--CountUp-->
    <script src="{{ asset('/plugins/countUp/countUp.js') }}"></script>

    <!-- Quill -->
    <link href="{{ asset('/plugins/quilljs/quill.snow.css') }}" rel="stylesheet" />
    <script src="{{ asset('/plugins/quilljs/quill.min.js') }}"></script>

    <!-- Chartist -->
    <link href="{{ asset('/plugins/chartist/chartist.css') }}" rel="stylesheet" />
    <script src="{{ asset('/plugins/chartist/chartist.js') }}"></script>

    <!-- skeleton -->
    <link href="{{ asset('/plugins/skeleton/skeleton.css') }}" rel="stylesheet" />
    <script src="{{ asset('/plugins/skeleton/avnPlugin.js') }}"></script>
    <script src="{{ asset('/plugins/skeleton/avnSkeleton.js') }}"></script>

    <!-- Fonts -->
    <!--<link rel="dns-prefetch" href="https://fonts.gstatic.com">-->
    <!--<link href="{{ asset('/fonts/Raleway/Raleway_300_400_600.css') }}" rel="stylesheet" type="text/css">-->

    <!-- dropzone -->
    <link href="{{ asset('/plugins/dropzone/dist/dropzone.css') }}" rel="stylesheet" />
    <script src="{{ asset('/plugins/dropzone/dist/dropzone.js') }}"></script>
