@extends('admin.layout')

@section('layout_content')

    <div class="container-fluid  ">
        <!-- partial:partials/_settings-panel.html -->

        <!-- partial -->
        <div class="">
            <br><br><br>

            <div class="content-wrapper">
                <div class="row user-profile">
                    <div class="container">
                        <div class="main-body">
                            <div class="row gutters-sm">
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-column align-items-center text-center">
                                                <img src="{{__admin}}images/avatar.jpg" id="company-logo" alt="Admin" class="rounded-circle"
                                                     width="150">
                                                <div class="mt-3">
                                                    <h4>{{$admin->name}}</h4>
                                                    <p class="text-secondary mb-1">{{$admin->email}}</p>
                                                    <p class="text-secondary mb-1">{{$admin->login}}</p>
                                                    <p class="text-secondary mb-1"><a href="">****</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mt-3">
                                    </div>
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <div class="wrapper about-user">
                                                <h6 class="card-title"> @tt('General') </h6>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <h6 class="mb-0">@tt('Name')</h6>
                                                    </div>
                                                    <div class="col-sm-8 text-secondary">
                                                        {{$admin->name}}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <h6 class="mb-0">@tt('Email')</h6>
                                                    </div>
                                                    <div class="col-sm-8 text-secondary">
                                                        {{$admin->email}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8" id="updateProfilEnterprise">

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">
                                                <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab"
                                                    role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="info-tab" data-toggle="tab"
                                                           href="#info"
                                                           role="tab" aria-controls="info" aria-expanded="true">@tt('Change')</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="avatar-tab" data-toggle="tab"
                                                           href="#avatar"
                                                           role="tab" aria-controls="avatar">@tt('AVATAR')</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="wrapper">
                                                <hr>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="info" role="tabpanel"
                                                         aria-labelledby="info">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">Change password </h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <form role="form" method="post" action="{{Dvups_admin::classpath('index.php?path=dvups-admin/changepassword')}}" >
                                                                <table class="table">
                                                                    <tr class="form-group">
                                                                        <th>Old Password</th>
                                                                        <td>
                                                                            <input class="form-control" placeholder="Old Password" name="oldpwd" type="password" autocomplete="false" value=""  autofocus />
                                                                        </td>
                                                                     </tr>
                                                                    <tr class="form-group">
                                                                        <th>New Password</th>
                                                                        <td>
                                                                            <input class="form-control" placeholder="New Password" name="newpwd" type="password" autocomplete="false"  value="" />
                                                                        </td>
                                                                     </tr>

                                                                </table>
                                                                <button type="submit" class="btn btn-lg btn-success btn-block">Changer</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->

@endsection
