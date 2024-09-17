@if ($message = Session::get('success'))
<div class="alert alert-success">
    {{ $message }}
</div>
@endif

@if($errors->has('success'))
    <div class="alert alert-success">
      <ul>
        @foreach ($errors-> get('success') as $error)
            <li style="list-style-type: none;">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
@endif


@if ($message = Session::get('error'))
<div class="alert alert-danger">
    {{ $message }}
</div>
@endif

@if($errors->has('error'))
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors-> get('error') as $error)
            <li style="list-style-type: none;">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul style="width: 100%; max-height: 55px; overflow: auto">
            @foreach ($errors->all() as $error)
                <li style="list-style-type: none;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning">
	{{ $message }}
</div>
@endif

@if($errors->has('error'))
    <div class="alert alert-warning">
      <ul>
        @foreach ($errors-> get('warning') as $error)
            <li style="list-style-type: none;">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info">
	{{ $message }}
</div>
@endif

@if($errors->has('info'))
    <div class="alert alert-info">
      <ul>
        @foreach ($errors-> get('info') as $error)
            <li style="list-style-type: none;">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
@endif

{{--@if ($errors->any())
<div class="alert alert-danger">
    <ul class="p-0">
        @foreach ($errors->all() as $error)
            <li style="list-style-type: none;">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif--}}
