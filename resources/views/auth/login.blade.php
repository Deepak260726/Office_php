@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col col-login mx-auto">
      <div class="text-center mb-6">
        <!--<img alt="" src="./assets/brand/tabler.svg" class="h-6">-->
      </div>
      <form class="card" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="card-body p-6">
          <div class="card-title">Login to your account</div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Email address</label>
            <input type="email" class="col-sm-8 form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter email">
            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">
              Password
            </label>
            <input type="password" class="col-sm-8 form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" required placeholder="Enter Password">
            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}> <span class="custom-control-label">Remember me</span>
            </label>
          </div>
          <div class="form-footer row">
            <button type="submit" class="col-sm-12 btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
