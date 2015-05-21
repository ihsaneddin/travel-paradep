{{ Form::model($route, ['route' => Helpers::createOrUpdateRoute($route),
             'class' => 'form form-horizontal update-data-table form-station',
              'id' => 'route-form', 'method' => Helpers::createOrUpdateMethod($route)]) }}


  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title pull-left">Route Basic Information</h3>
          </div>

          <div class="panel-body">

            <div class="form-group {{ Helpers::inputError($errors, 'name') }}">
              {{ Form::label('name', 'Name', array('class' => 'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('name', input_value($route->name,Input::old('name')), array('class' => 'form-control', 'placeholder' => 'Name')) }}
                <span class='help-inline'>
                  {{ $errors->first('name') }}
                </span>
              </div>
            </div>

            <div class="form-group {{ Helpers::inputError($errors, 'code') }}">
              {{ Form::label('code', 'Code', array('class' => 'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('code', input_value($route->code,Input::old('code')), array('class' => 'form-control', 'placeholder' => 'Code')) }}
                <span class='help-inline'>
                  {{ $errors->first('code') }}
                </span>
              </div>
            </div>

            <div class="form-group {{ Helpers::inputError($errors, 'category_id') }}">
              {{ Form::label('category_id', 'Class', array('class' => 'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::select('category_id', $options['categories'], Input::old('category_id'),
                              array('class' => 'form-control', 'id' => 'category_id')) }}
                <span class='help-inline'>
                  {{ $errors->first('category_id') }}
                </span>
              </div>
            </div>

            <div class="form-group {{ Helpers::inputError($errors, 'price') }}">
              {{ Form::label('price', 'Price (Rp)', array('class' => 'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('price', input_value($route->price,Input::old('price')), array('class' => 'form-control', 'placeholder' => 'Price')) }}
                <span class='help-inline'>
                  {{ $errors->first('price') }}
                </span>
              </div>
            </div>

          </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">From/To</h3>
              <div class="pull-right panel-action">
                <div class="btn-group">

                  {{Helpers::link_to('admin.master.stations.create', '<i class="icon icon-plus"></i>', [],['class' => 'btn btn-default new-modal-form new-object', 'data-target' => 'modal-new-station'])}}

                </div>
              </div>
        </div>

        <div class="panel-body">
          <div class="form-group {{ Helpers::inputError($errors, 'departure') }}">
            {{ Form::label('departure', 'Departure', array('class' => 'col-md-2 control-label')) }}
            <div class="col-md-10">
              {{ Form::select('departure', $options['stations'], Input::old('departure'),
                              array('class' => 'form-control station-options', 'id' => 'departure')) }}
              <span class='help-inline'>
                {{ $errors->first('departure') }}
              </span>
            </div>
          </div>

          <div class="form-group {{ Helpers::inputError($errors, 'destination') }}">
            {{ Form::label('destination', 'Destination', array('class' => 'col-md-2 control-label')) }}
            <div class="col-md-10">
              {{ Form::select('destination', $options['stations'], Input::old('destination'),
                              array('class' => 'form-control station-options', 'id' => 'destination')) }}
              <span class='help-inline'>
                {{ $errors->first('destination') }}
              </span>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>


  <span class='notify-success-text hidden'> Route is successfully {{$route->exists() ? 'updated' : 'created'}}. </span>

{{Form::close()}}

<script>
    $(document).ready(function(){

      $('form#route-form').each(function(){
        var form =$(this);
        form.find('select').each(function(){
          if ( !$(this).hasClass('selectized') )
          {
            initSelectize($(this), {create:false});
          }
        });
      });
    });
</script>