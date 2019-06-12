@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Mettre à jour mon profil
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       @include('flash::message')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}

                        <!-- Name Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Email Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::email('email', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Password Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('password', 'Password:') !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>

                        <!-- Mobile Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('mobile', 'Mobile:') !!}
                            {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Role Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('role', 'Role:') !!}
                            {!! Form::select('role', ['0' => 'Utilisateur', '1' => 'Administrateur'], $user->role, ['class' => 'form-control', 'disabled' => 'true' ]) !!}
                        </div>

                        <!-- Photo Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('photo', 'Photo:') !!}
                            {!! Form::file('photo') !!}
                        </div>
                        <div class="clearfix"></div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
                        </div>


                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection