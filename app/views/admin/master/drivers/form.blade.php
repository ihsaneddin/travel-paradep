{{ Form::model($driver, ['route' => Helpers::createOrUpdateRoute($driver),
             'class' => 'form form-horizontal update-data-table form-driver',
              'id' => 'driver-form', 'method' => Helpers::createOrUpdateMethod($driver)]) }}

    <div class="form-group {{ Helpers::inputError($errors, 'name') }}">
      {{ Form::label('name', 'Name', array('class' => 'col-md-2 control-label')) }}
      <div class="col-md-10">
        {{ Form::text('name', input_value($driver->name,Input::old('name')), array('class' => 'form-control', 'placeholder' => 'Name')) }}
        <span class='help-inline'>
          {{ $errors->first('name') }}
        </span>
      </div>
    </div>

    <div class="form-group {{ Helpers::inputError($errors, 'code') }}">
      {{ Form::label('code', 'Code', array('class' => 'col-md-2 control-label')) }}
      <div class="col-md-10">
        {{ Form::text('code', input_value($driver->code,Input::old('code')), array('class' => 'form-control', 'placeholder' => 'Code')) }}
        <span class='help-inline'>
          {{ $errors->first('code') }}
        </span>
      </div>
    </div>

    <span class='notify-success-text hidden'> Driver is successfully {{$driver->exists() ? 'updated' : 'created'}}. </span>

{{Form::close()}}