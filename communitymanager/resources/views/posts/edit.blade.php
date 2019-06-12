@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Post
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'patch']) !!}

                        <!-- Content Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::label('content', 'Content:') !!}
                            {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
                        </div>
                        <!-- Content Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::label('image_url', 'Image URL:') !!}
                            {!! Form::text('image_url', null, ['class' => 'form-control', 'disabled'=>'true',]) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('posts.index') !!}" class="btn btn-default">Cancel</a>
                        </div>
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection