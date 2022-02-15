@php
    $admin = getadmin();
        $notifications = Notificationbroadcasted::unreadedadmin($admin);
        $nbnots = Notificationbroadcasted::unreadedadmincount($admin);
@endphp
<div class="btn-group  dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        @if($nbnots)<span class="badge badge-danger badge-counter">{{$nbnots}}</span>@endif
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
         aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
            Notifications ({{Notificationbroadcasted::where("admin.id", $admin->id)->count()}})
        </h6>
        @foreach($notifications as $notification)
            <a class="dropdown-item d-flex align-items-center" href="{{ $notification->getRedirect()}}">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">{{ (new DateTime($notification->created_at))->format("D, M Y") }}</div>
                    <span class="font-weight-bold">{!! $notification->notification->content !!}</span>
                </div>
            </a>
        @endforeach
        <a class="dropdown-item text-center small text-gray-500"
           href="{{Notificationbroadcasted::classpath('notificationbroadcasted/list')}}">Show All Alerts</a>
    </div>
</div>

