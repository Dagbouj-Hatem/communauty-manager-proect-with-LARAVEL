@extends('layouts.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profil de l'utilisateur
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
            @if($user->photo)
               <img class="profile-user-img img-responsive img-circle" src="{{ $user->photo }}" alt="User profile picture">
            @else
              <img class="profile-user-img img-responsive img-circle" src="https://cdn4.iconfinder.com/data/icons/avatars-21/512/avatar-circle-human-male-3-512.png" alt="User profile picture">
            @endif

              <h3 class="profile-username text-center">{!! $user->name !!}</h3>

              <p class="text-muted text-center">{!! $user->email !!}</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Identifiant</b> <a class="pull-right">{!! $user->id !!}</a>
                </li>
                <li class="list-group-item">
                  <b>Mobile</b> <a class="pull-right">{!! $user->mobile !!}</a>
                </li>
                <li class="list-group-item">
                  <b>Role</b> <a class="pull-right">
                    @if($user->role) {{ 'Administrateur' }}
                    @else {{ 'Utilisateur' }}
                    @endif
                </a>
                </li>
              </ul>

              <a href="{!! route('users.index') !!}" class="btn btn-primary btn-block"><b>Back</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-user-plus"></i> Mombre depuis</strong>

              <p class="text-muted">
               {!! $user->created_at->format('D M. Y') !!}
              </p>

              <hr>

              <strong><i class="fa fa-edit"></i> Dernière mise à jour</strong>

              <p class="text-muted">{!! $user->updated_at->format('D M. Y') !!}</p>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Historiques des connexions</a></li>
              <li><a href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                        @include('users.show_fields')
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="settings">
                      @include('adminlte-templates::common.errors')
                       <div class="box box-primary">
                           <div class="box-body">
                               <div class="row">
                                   {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}

                                        @include('users.fields')

                                   {!! Form::close() !!}
                               </div>
                           </div>
                       </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->

@endsection
