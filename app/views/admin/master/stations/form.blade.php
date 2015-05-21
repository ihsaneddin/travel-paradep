{{ Form::model($station, ['route' => Helpers::createOrUpdateRoute($station),
             'class' => 'form form-horizontal update-data-table form-station',
              'id' => 'station-form', 'method' => Helpers::createOrUpdateMethod($station)]) }}

    <div class="form-group {{ Helpers::inputError($errors, 'name') }}">
      {{ Form::label('name', 'Name', array('class' => 'col-md-2 control-label')) }}
      <div class="col-md-10">
        {{ Form::text('name', input_value($station->name,Input::old('name')), array('class' => 'form-control', 'placeholder' => 'Name')) }}
        <span class='help-inline'>
          {{ $errors->first('name') }}
        </span>
      </div>
    </div>

    <div class="form-group {{ Helpers::inputError($errors, 'code') }}">
      {{ Form::label('code', 'Code', array('class' => 'col-md-2 control-label')) }}
      <div class="col-md-10">
        {{ Form::text('code', input_value($station->code,Input::old('code')), array('class' => 'form-control', 'placeholder' => 'Code')) }}
        <span class='help-inline'>
          {{ $errors->first('code') }}
        </span>
      </div>
    </div>

    @foreach($station->addresses as $index => $address)

      {{ Form::hidden('addresses['.$index.'][id]', $address->id) }}

      <div class="form-group {{Helpers::inputError($errors, 'addresses['.$index.'][name]')}}">
        {{Form::label('addresses['.$index.'][name]', 'Address',
                      ['class' => 'col-md-2 control-label']) }}
        <div class="col-md-10">
            {{ Form::text('addresses['.$index.'][name]',
                            input_value($address->name,Input::old('addresses['.$index.'][name]')),
                            ['class' => 'form-control', 'placeholder' => 'Address'] )}}
            <span class="help-inline">
            {{ $errors->first('addresses['.$index.'][name]') }}
            </span>
        </div>
      </div>

      <div class="form-group {{Helpers::inputError($errors, 'addresses['.$index.'][city]')}}">
        {{Form::label('addresses['.$index.'][city]', 'City',
                      ['class' => 'col-md-2 control-label']) }}
        <div class="col-md-10">
            {{ Form::text('addresses['.$index.'][city]',
                            input_value($address->city,Input::old('addresses['.$index.'][city]')),
                            ['class' => 'form-control', 'placeholder' => 'City'] )}}
            <span class="help-inline">
            {{ $errors->first('addresses['.$index.'][city]') }}
            </span>
        </div>
      </div>

      <div class="form-group {{Helpers::inputError($errors, 'addresses['.$index.'][state]')}}">
        {{Form::label('addresses['.$index.'][state]', 'Province',
                      ['class' => 'col-md-2 control-label']) }}
        <div class="col-md-10">
            {{ Form::text('addresses['.$index.'][state]',
                            input_value($address->state,Input::old('addresses['.$index.'][state]')),
                            ['class' => 'form-control', 'placeholder' => 'Province'] )}}
            <span class="help-inline">
            {{ $errors->first('addresses['.$index.'][state]') }}
            </span>
        </div>
      </div>
    @endforeach

    <span class='notify-success-text hidden'> Station is successfully {{$station->exists() ? 'updated' : 'created'}}. </span>

{{Form::close()}}