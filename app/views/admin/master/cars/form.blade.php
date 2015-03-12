{{ Form::model($car, ['route' => Helpers::createOrUpdateRoute($car), 
             'class' => 'form form-horizontal update-data-table form-car',
              'id' => 'car-form', 'method' => Helpers::createOrUpdateMethod($car)]) }}
    <div class="form-group {{ Helpers::inputError($errors, 'car_id') }}">
      {{ Form::label('car', 'Car', array('class' => 'col-md-2 control-label')) }}
      <div class="col-md-10">
        {{ Form::select('car_id', $carList, Input::old('car_id'),
                        array('class' => 'form-control need-manufacture', 'id' => 'car_id')) }}
        <span class='help-inline'>
          {{ $errors->first('car_id') }}
        </span>
      </div>
    </div>

    <div class="form-group {{ Helpers::showOrHidden($errors->first('manufacture')) }} {{ Helpers::inputError($errors, 'manufacture') }} manufacture-input">
      {{ Form::label('manufacture', 'Manufacture', array('class' => 'col-md-2 control-label')) }}
      <div class="col-md-10">
        {{ Form::text('manufacture', Input::old('manufacture'), array('class' => 'form-control', 'id' => 'manufacture')) }}
        <span class='help-inline'>
          {{ $errors->first('manufacture') }}
        </span>
      </div>
    </div>

    <div class="form-group {{ Helpers::inputError($errors, 'category_id') }}">
      {{ Form::label('category_id', 'Class', array('class' => 'col-md-2 control-label')) }}
      <div class="col-md-10">
        {{ Form::select('category_id', $categories, Input::old('category_id'), 
                      array('class' => 'form-control', 'id' => 'category_id')) }}
        <span class='help-inline'>
          {{ $errors->first('category_id') }}
        </span>
      </div>
    </div>

    <div class="form-group {{ Helpers::inputError($errors, 'license_no') }}">
      {{ Form::label('license_no', 'License Number', array('class' => 'col-md-2 control-label')) }}
      <div class="col-md-10">
        {{ Form::text('license_no', Input::old('license_no'), array('class' => 'form-control')) }}
        <span class='help-inline'>
          {{ $errors->first('license_no') }}
        </span>
      </div>
    </div>

    <div class="form-group {{ Helpers::inputError($errors, 'stnk_no') }}">
      {{ Form::label('stnk_no', 'STNK Number', array('class' => 'col-md-2 control-label')) }}
      <div class="col-md-10">
        {{ Form::text('stnk_no', Input::old('stnk_no'), array('class' => 'form-control')) }}
        <span class='help-inline'>
          {{ $errors->first('stnk_no') }}
        </span>
      </div>
    </div>

    <div class="form-group {{ Helpers::inputError($errors, 'bpkb_no') }}">
      {{ Form::label('bpkb_no', 'BPKB Number', array('class' => 'col-md-2 control-label')) }}
      <div class="col-md-10">
        {{ Form::text('bpkb_no', Input::old('bpkb_no'), array('class' => 'form-control')) }}
        <span class='help-inline'>
          {{ $errors->first('bpkb_no') }}
        </span>
      </div>
    </div>

    <div class="form-group {{ Helpers::inputError($errors, 'seat') }}">
      {{ Form::label('seat', 'Total Seat', array('class' => 'col-md-2 control-label')) }}
      <div class="col-md-10">
            {{ Form::selectRange('seat', 8,20,
               is_null(Input::old('seat')) ? 10 : Input::old('seat'),
               array('class' => 'form-control', 'id' => 'seat')) }}
        <span class='help-inline'>
          {{ $errors->first('seat') }}
        </span>
      </div>
    </div>

    <div class="autocomplete">
      
    </div>

    <span class='notify-success-text hidden'> Car is successfully {{$car->exists() ? 'updated' : 'created'}}. </span>

{{Form::close()}}

<script type="text/javascript" src="{{asset('assets/js/car-form.js')}}"></script>