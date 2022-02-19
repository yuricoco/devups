<a class="dropdown-item d-flex align-items-center @if(!$notification->status) bg-info @endif" href="{{ $notification->getRedirect()}}">
    @if(!$notification->status)
        <input type="checkbox" name="ids[]" value="{{$notification->id}}" checked hidden >
    @endif
    <div class="mr-3">
        <div class="icon-circle bg-primary ">
            <i class="fas fa-file-alt text-white"></i>
        </div>
    </div>
    <div>
        <div class="small text-gray-500">{{ (new DateTime($notification->created_at))->format("D, M Y") }}</div>
        <span class="@if(!$notification->read) font-weight-bold @endif">{!! $notification->notification->content !!}</span>
    </div>
</a>