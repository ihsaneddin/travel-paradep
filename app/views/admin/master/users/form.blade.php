
{{Form::model($user, ['route' => Helpers::createOrUpdateRoute($user), 
             'class' => 'form-and-autocomplete form form-horizontal update-data-table',
              'id' => 'user-form'])}}

    <div class="form-group {{Helpers::inputError($errors, 'username')}}">
        {{Form::label('username',
                      'Username', 
                      array('class' => 'col-md-2 control-label'))}}
        
        <div class="col-md-10 ">
            {{Form::text('username',
                         Input::old('username'), 
                         ['class' => 'form-control', 'placeholder' => 'User name']) }}
             <span class="help-inline">
                {{ $errors->first('username') }}             
             </span>
        </div>
    </div>

    <div class="form-group {{Helpers::inputError($errors, 'email')}}">
        {{Form::label('email', 'Email',
                      ['class' => 'col-md-2 control-label']) }}
        <div class="col-md-10">
            {{ Form::email('email',
                            $user->email,
                            ['class' => 'form-control', 'placeholder' => 'User email'] )}}
            <span class="help-inline">
            {{ $errors->first('email') }}             
            </span>
        </div>
    </div>
    <div class="form-group {{Helpers::inputError($errors, 'password')}}">
        {{Form::label('password', 'Password',
                      ['class' => 'col-md-2 control-label']) }}
        <div class="col-md-10">
            {{ Form::password('password',
                            ['class' => 'form-control', 'placeholder' => 'User password'] )}}
            <span class="help-inline">
                {{ $errors->first('password') }}             
            </span>
        </div>
    </div>
    <div class="form-group {{Helpers::inputError($errors, 'password_confirmation')}}">
        {{Form::label('password_confirmation', 'Password Confirmation',
                      ['class' => 'col-md-2 control-label']) }}
        <div class="col-md-10">
            {{ Form::password('password_confirmation',
                            ['class' => 'form-control', 'placeholder' => 'Confirm Password'] )}}
            <span class="help-inline">
                {{ $errors->first('password_confirmation') }}             
             </span>
        </div>
    </div>

    <div class="form-group {{Helpers::inputError($errors, 'role_ids')}}">
        {{Form::label('role_ids',
                      'Roles', 
                      array('class' => 'col-md-2 control-label'))}}
        
        <div class="col-md-10">
            {{Form::text('role_ids',
                         '', 
                         ['class' => 'form-control token-autocomplete',
                          'placeholder' => 'Type a role']) }}
            <span class="help-inline">
                {{ $errors->first('role_ids') }}             
             </span>
        </div>
    </div>

    <div class="autocomplete">
      {{Helpers::autocomplete(Role::autocompleteAll(),'role_ids')}}
        @if (!is_null($user->id))
          {{Helpers::currentAutocomplete(array_map(function($role){return ['id' => $role['id'], 'name' => $role['name']];} ,$user->roles()->get()->toArray()), 'role_ids')}}
        @endif
    </div>

    <span class='notify-success-text hidden'> User is successfully {{$user->exists() ? 'updated' : 'created'}}. </span>

{{Form::close()}}
