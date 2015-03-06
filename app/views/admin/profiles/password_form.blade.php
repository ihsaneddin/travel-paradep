{{Form::model($user, ['route' => ['admin.profiles.change_password', $user->id], 
             'class' => 'form form-horizontal',
              'id' => 'edit-password-form', 'method' => 'put'])}}

  <div class="form-group {{Helpers::inputError($errors, 'old_password')}}">
      {{Form::label('old_password',
                    'Old Password', 
                    array('class' => 'col-md-2 control-label'))}}
      
      <div class="col-md-10 ">
          {{Form::password('old_password', ['class' => 'form-control']) }}
           <span class="help-inline">
              {{ $errors->first('old_password') }}             
           </span>
      </div>
  </div>

  <div class="form-group {{Helpers::inputError($errors, 'password')}}">
      {{Form::label('password',
                    'New Password', 
                    array('class' => 'col-md-2 control-label'))}}
      
      <div class="col-md-10 ">
          {{Form::password('password', ['class' => 'form-control']) }}
           <span class="help-inline">
              {{ $errors->first('password') }}             
           </span>
      </div>
  </div>

  <div class="form-group {{Helpers::inputError($errors, 'password_confirmation')}}">
      {{Form::label('password_confirmation',
                    'Password Confirmation', 
                    array('class' => 'col-md-2 control-label'))}}
      
      <div class="col-md-10 ">
          {{Form::password('password_confirmation', ['class' => 'form-control']) }}
           <span class="help-inline">
              {{ $errors->first('password_confirmation') }}             
           </span>
      </div>
  </div>
     

<span class='notify-success-text hidden'> Password is successfully changed. </span>
{{Form::close()}}

