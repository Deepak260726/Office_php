<h1 class="float-left page-title" style="color: #04246A;">
  @isset($data['page_title_icon'])
    <em class="page-title-icon fa {{ $data['page_title_icon'] }}"></em>
 @endisset
 {!! $data['page_title'] !!}
</h1>