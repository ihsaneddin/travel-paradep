{{Form::model($user, ['route' => Helpers::createOrUpdateRoute($user),
             'class' => 'form form-horizontal',
              'id' => 'edit-profile-form', 'method' => 'put', 'files' => true])}}

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

<div class="form-group {{Helpers::inputError($errors, 'avatar')}}">
  {{Form::label('profile picture', 'Avatar',
                ['class' => 'col-md-2 control-label']) }}
  <div class="col-md-10">
      {{ Form::file('avatar',
                      ['class' => 'form-control fileinput', 'id' => 'avatar'] )}}
      <span class="help-inline">
      {{ Helpers::errorMessage($errors, 'avatar') }}
      </span>
      {{  Form::hidden('_delete','' , ['id' => '_delete']) }}
  </div>
</div>

<span class='notify-success-text hidden'> Profile updated. </span>
{{Form::close()}}

<script type="text/javascript" src="{{asset('assets/plugins/kartik-v-bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/update-profile.js')}}"></script>
