@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Paramétres de l'application
        </h1>
   </section>
   <div class="content">

       @include('flash::message')

      
       <div class="box box-primary">
	       	<div class="box-header with-border text-center">
	          <h2 class="box-title text-center text-danger">Configuration de la l'application</h2>

	          <div class="box-tools pull-right">
	            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
	              <i class="fa fa-minus"></i></button>
	            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
	              <i class="fa fa-times"></i></button>
	          </div>
	        </div>
	           <div class="box-body">
	               <div class="row">
	               	{!! Form::model( ['route' => ['settings.update'], 'method' => 'post']) !!}
	               			<!-- Name Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('name', 'Application Name:') !!}
								{!! Form::text('name', config('app.name'), ['class' => 'form-control']) !!} 
							</div>	
							<!-- Application Environment Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('env', 'Application Environment:') !!}
							    {!! Form::select('env', ['local' => 'local', 'staging' => 'staging'], config('app.env'), ['class' => 'form-control']) !!} 
							</div>               			
							<!-- Application Debug Mode Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('debug', 'Application Debug Mode:') !!}
							    {!! Form::select('debug', [true => 'true', false => 'false'], config('app.debug'), ['class' => 'form-control']) !!}  
							</div>	
							<!-- url Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('url', 'Application URL:') !!}
								{!! Form::text('url', config('app.url'), ['class' => 'form-control']) !!}  
							</div>
							<!-- Application Locale Configuration Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('locale', 'Application Locale Configuration:') !!}
							    {!! Form::select('locale', ['fr' => 'fr', 'en' => 'en'], config('app.locale'), ['class' => 'form-control']) !!}   
							</div>	
							<!-- Faker Locale Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('faker_locale', 'Faker Locale:') !!}
							    {!! Form::select('faker_locale', ['fr_FR' => 'fr_FR', 'en_US' => 'en_US','ar_SA'=>'ar_SA'], config('app.faker_locale'), ['class' => 'form-control']) !!}   
							</div>						
							<!-- Encryption Key Field -->
							<div class="form-group col-sm-12">
								{!! Form::label('key', 'Encryption Key:') !!}
								{!! Form::text('key', config('app.key'), ['class' => 'form-control', 'disabled'=>'true']) !!} 
							</div>



								<h4 class="box-title text-center text-danger">Configuration de la base de données</h4>
							
							<!-- DB_CONNECTION Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('driver', 'DB_CONNECTION:') !!}
								{!! Form::text('driver', config('database.connections.mysql.driver'), ['class' => 'form-control' , 'disabled'=> 'true']) !!} 
							</div>
							<!-- DB_HOST Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('host', 'DB_HOST:') !!}
								{!! Form::text('host', config('database.connections.mysql.host'), ['class' => 'form-control' ]) !!} 
							</div>
							<!-- DB_PORT Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('port', 'DB_PORT:') !!}
								{!! Form::text('port', config('database.connections.mysql.port'), ['class' => 'form-control' ]) !!} 
							</div>
							<!-- DB_DATABASE Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('database', 'DB_DATABASE:') !!}
								{!! Form::text('database', config('database.connections.mysql.database'), ['class' => 'form-control' ]) !!} 
							</div>
							<!-- DB_USERNAME Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('username', 'DB_USERNAME:') !!}
								{!! Form::text('username', config('database.connections.mysql.username'), ['class' => 'form-control' ]) !!} 
							</div>	
							<!-- DB_PASSWORD Field -->
							<div class="form-group col-sm-4">
								{!! Form::label('password', 'DB_PASSWORD:') !!}
								{!! Form::text('password', config('database.connections.mysql.password'), ['class' => 'form-control' ]) !!} 
							</div>	
							<!-- submit Field -->
							<div class="form-group col-sm-offset-10 col-sm-2 text-center"> 
								{!! Form::submit('Sauvegarder', ['class' => 'btn btn-success btn-block']) !!} 
							</div>
	               	
	               	{!! Form::close() !!}		
	               </div>
	           </div>
       </div> 

        
   </div>
@endsection