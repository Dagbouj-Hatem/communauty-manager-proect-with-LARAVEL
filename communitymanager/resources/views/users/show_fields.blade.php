       
@if($user->authentications()->first())
          <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                  <th>Identifiant</th>
                  <th>Username</th>
                  <th>Adresse IP</th>
                  <th>connectez-vous à</th>
                  <th>se déconnecter à</th>
                </tr>
            </thead>
                <tbody>
                	@foreach($user->authentications as $auth )
			                <tr>
                        <td>{{ $auth->id }}</td>
			                  <td>{{ $auth->authenticatable->name }}</td>
			                  <td>{{ $auth->ip_address }}</td>
			                  <td>{{ $auth->login_at }}</td>
			                  <td>{{ $auth->logout_at }}</td>
			                </tr>
			           @endforeach
            </tbody>
          </table>
<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'last Login At:') !!}
    <p>{!! $user->lastLoginAt() !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'last Login Ip:') !!}
    <p>{!! $user->lastLoginIp() !!}</p>
</div>

@else 
    <p class="text-center text-info" style="margin-top: 100px;">
      aucune authentification disponible
    </p>
@endif

