{{Form::model($user, ['route' => Helpers::createOrUpdateRoute($user), 
             'class' => 'form-and-autocomplete form form-horizontal',
              'id' => 'user-form', 'method' => 'put'])}}

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
  @foreach( $user->childs['avatar'] as $avatar )   
  <div class="form-group {{Helpers::inputError($errors, 'avatar[0][name]')}}">
    {{Form::label('profile picture', 'Avatar',
                  ['class' => 'col-md-2 control-label']) }}
    <div class="col-md-10">
        {{ Form::email('avatar[0][name]',
                        '',
                        ['class' => 'form-control', 'placeholder' => 'User email'] )}}
        <span class="help-inline">
        {{ Helpers::errorMessage($errors, 'avatar[0][name]') }}             
        </span>
    </div>
  </div>
  @endforeach
</div>

{{Form::close()}}
