
@foreach($data['comments'] as $item)
<div class="d-flex flex-row project-activity-item">
  <div class="float-left activity-user">
    {!! App\Helpers\UserHelper::getUserAvatar($item->CommentUser->first_name, $item->CommentUser->last_name) !!}
  </div>
  <div class="float-right activity-content {{ ($item->type == App\Constants\SupportConstant::FIRST_ANALYSIS ) ? 'bg-warning-light' : '' }}">
    <span class="text-primary">{{ $item->CommentUser->first_name.' '.$item->CommentUser->last_name }}</span>
    <span class="text-muted">{{ $item->created_at->format('d M Y') }}</span>
    {!! App\Helpers\SupportHelper::getCommentTypeHtml($item->type) !!}
    <div id="comment_text_{{ $item->id }}">{!! App\Helpers\GlobalHelper::encode_html_excluding_allowed_tags($item->comments) !!}</div>
  </div>
</div>
@endforeach
