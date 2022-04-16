@php
    $admin = getadmin();
        $data = Notification::unreadedadmin($admin);
        $notifications = $data["notifs"];
        $nbnots = $data["notifcount"];
@endphp
<div id="notification-block" class="btn-group  dropdown no-arrow mx-1">
    <a onclick="devups.notified(this)" class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
       data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <span @if(!$nbnots) hidden @endif id="notif-ping" class="badge badge-danger badge-counter">{{$nbnots}}</span>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
         aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
            Notifications ({{Notification::where("admin_id", $admin->id)->count()}})
        </h6>
        <div id="notification-items" style="max-height: 500px; overflow: auto">
            @foreach($notifications as $notification)
                @include("default.notification_item")
            @endforeach
        </div>
        <a class="dropdown-item text-center small text-gray-500"
           href="{{Notification::classview('notification/list')}}">Show All Alerts</a>
    </div>
</div>

