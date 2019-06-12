@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Modifier les informations
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($page, ['route' => ['pages.update', $page->id], 'method' => 'patch']) !!}

                    <!-- Url Field -->
                    <div class="form-group col-sm-12">
                    {!! Form::label('name', 'Nom:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'disabled' => 'true']) !!}
                    </div>

                    <!-- Id Fb Page Field -->
                    <div class="form-group col-sm-12">
                    {!! Form::label('about', 'À propos:') !!}
                    {!! Form::textarea('about', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Picture Field -->
                    <div class="form-group col-sm-6">
                    {!! Form::label('picture', 'Photo Url :') !!}
                    {!! Form::text('picture', null, ['class' => 'form-control', 'disabled' => 'true']) !!}
                    </div> 
                    <!-- Access Token Field -->
                    <div class="form-group col-sm-6">
                    {!! Form::label('cover_photo', 'Cover Url:') !!}
                    {!! Form::text('cover_photo', null, ['class' => 'form-control', 'disabled' => 'true']) !!}
                    </div>

                    <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    <a href="{!! route('pages.index') !!}" class="btn btn-default">Cancel</a>
                    </div>

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection