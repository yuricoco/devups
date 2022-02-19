<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                        data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
                <span>
                    <button type="button"
                            class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-left">
            <div class="search-wrapper">
                <div class="input-holder">
                    <input type="text" class="search-input" placeholder="Type to search">
                    <button class="search-icon"><span></span></button>

                </div>
                <button class="close"></button>
            </div>
            <ul class="header-menu nav">
                <li>
                    <a href="{{__env}}" target="_blank">
                        <i class="fa fa-share"></i>
                        aller sur le site
                    </a>
                </li>
                <li class="ml-3">
                    <div class="btn-group">
                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                           class="p-0 btn ">
                            | Shortcut
                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                        </a>
                        <div tabindex="-1" role="menu" aria-hidden="true"
                             class="dropdown-menu dropdown-menu-right">
                            <a href="{{__env . 'admin/devupscms/ModuleData/status/list'}}"
                               class="dropdown-item">{{t("Status")}}</a>
                            <a href="{{Reportingmodel::classview("reportingmodel/list")}}"
                               class="dropdown-item">{{t("Email manager")}}</a>
                            <a href="{{Notification::classpath("index.php")}}"
                               class="dropdown-item">{{t("Notifications")}}</a>
                            <a href="{{Reportingmodel::classview("emaillog/list")}}"
                               class="dropdown-item">{{t("Log")}}</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">

                            @include("default.notification")

                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                   class="p-0 btn">
                                    <img width="42" class="rounded-circle" src="{{__admin}}images/avatar.png" alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                     class="dropdown-menu dropdown-menu-right">
                                    <a href="{{__env . 'admin/devups/ModuleAdmin/dvups-admin/profile'}}"
                                       class="dropdown-item">{{t("Admin Account")}}</a>
                                    <a href="<?= Dvups_admin::classpath() . 'dvups-admin/editpassword' ?>"
                                       class="dropdown-item">
                                        <i class="mdi mdi-settings text-primary"></i>
                                        {{t("Settings")}}
                                    </a>
                                    <a class="dropdown-item"
                                       href="<?= __env . 'admin/index.php?path=deconnexion' ?>">
                                        <i class="mdi mdi-logout text-primary"></i>
                                        {{t("Logout")}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                {{ getadmin()->getName() }}
                            </div>
                            <div class="widget-subheading">
                                {{ getadmin()->dvups_role->getName() }}
                            </div>
                        </div>
                        <div class="widget-content-right header-user-info ml-3">
                            <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
