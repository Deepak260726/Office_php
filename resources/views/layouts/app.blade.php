<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}" />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Office</title>

    <!-- Header SCripts -->
    @include('modules.header-scripts')

    <style>
      /* latin-ext */
      @font-face {
        font-family: 'Raleway';
        font-style: normal;
        font-weight: 300;
        src: local('Raleway Light'), local('Raleway-Light'), url({{ asset('/fonts/raleway/1Ptrg8zYS_SKggPNwIYqWqhPAMif.woff2)') }} format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      /* latin */
      @font-face {
        font-family: 'Raleway';
        font-style: normal;
        font-weight: 300;
        src: local('Raleway Light'), local('Raleway-Light'), url({{ asset('/fonts/raleway/1Ptrg8zYS_SKggPNwIYqWqZPAA.woff2') }} format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }
      /* latin-ext */
      @font-face {
        font-family: 'Raleway';
        font-style: normal;
        font-weight: 400;
        src: local('Raleway'), local('Raleway-Regular'), url({{ asset('/fonts/raleway/1Ptug8zYS_SKggPNyCMIT5lu.woff2') }} format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      /* latin */
      @font-face {
        font-family: 'Raleway';
        font-style: normal;
        font-weight: 400;
        src: local('Raleway'), local('Raleway-Regular'), url({{ asset('/fonts/raleway/1Ptug8zYS_SKggPNyC0ITw.woff2') }} format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }
      /* latin-ext */
      @font-face {
        font-family: 'Raleway';
        font-style: normal;
        font-weight: 600;
        src: local('Raleway SemiBold'), local('Raleway-SemiBold'), url({{ asset('/fonts/raleway/1Ptrg8zYS_SKggPNwPIsWqhPAMif.woff2') }} format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      /* latin */
      @font-face {
        font-family: 'Raleway';
        font-style: normal;
        font-weight: 600;
        src: local('Raleway SemiBold'), local('Raleway-SemiBold'), url({{ asset('/fonts/raleway/1Ptrg8zYS_SKggPNwPIsWqZPAA.woff2') }} format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }
    </style>
  </head>
  <body style="min-width:1200px;">
    <div class="page">
      <div class="page-main">
        <!-- Header -->
        @include('modules.header')
        
        <div class="mb-3 mt-0">
          @include('modules.flash-message')
          
          @yield('content')
        </div>
      </div>
      
      <!-- Footer -->
      @include('modules.footer')
    </div>
  </body>
</html>
