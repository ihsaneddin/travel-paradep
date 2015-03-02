{{Form::model($user, ['route' => Helpers::createOrUpdateRoute($user), 
             'class' => 'form-and-autocomplete form form-horizontal',
              'id' => 'user-form'])}}

<div class="form-group {{Helpers::inputError($errors, 'username')}}">
    {{Form::label('username',
                  'Username', 
                  array('class' => 'col-md-2 control-label'))}}
    
    <div class="col-md-10 ">
        {{Form::text('username',
                     $user->username, 
                     ['class' => 'form-control', 'placeholder' => 'User name']) }}
         <span class="help-inline">
            {{ $errors->first('username') }}             
         </span>
    </div>
</div>

<div class="fields-for fields-for-avatar">  
  <div class="form-group {{Helpers::inputError($errors, 'avatar[][name]')}}">
    {{Form::label('profile picture', 'Email',
                  ['class' => 'col-md-2 control-label']) }}
    <div class="col-md-10">
        {{ Form::email('avatar[][description]',
                        '',
                        ['class' => 'form-control', 'placeholder' => 'User email'] )}}
        <span class="help-inline">
        {{ $errors->first('avatar[][name]') }}             
        </span>
    </div>
  </div>
</div>

{{Form::close()}}
