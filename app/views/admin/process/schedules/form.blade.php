{{Form::model($schedule, ['route' => Helpers::createOrUpdateRoute($schedule),
             'class' => is_null($schedule->id) ? 'schedule-form form form-horizontal append-first-tr' : 'schedule-form form form-horizontal replace-tr',
              'id' => 'schedule-form', 'method' => Helpers::createOrUpdateMethod($schedule)])}}

  <div class="row">

    <div class="form-group col-md-12 {{ Helpers::inputError($errors, 'hour') }}">
      {{ Form::label('hour', 'Hour', array('class' => 'col-md-2 control-label ')) }}
      <div class="col-md-4">
        <div class="input-group date lala input-datetime-only-hour" data-date="{{ $schedule->hour }}" data-date-format="hh:ii" data-link-field="dummy_arrival_hour">
         {{ Form::text('hour', $schedule->hour,
                        array('class' => 'form-control', 'id' => 'hour')) }}
          <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
        </div>
        <span class='help-inline'>
          {{ $errors->first('hour') }}
        </span>
      </div>
    </div>

    <div class="row"></div>

    <div class="form-group col-md-12">
        {{ Form::label('weekend', 'Weekend?', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-9">
          <label class="checkbox-inline">
            {{ Form::checkbox('weekend', '1', $schedule->paid) }}
          </label>
          <span class='help-inline'>
          {{ $errors->first('weekend') }}
        </span>
        </div>
    </div>

    <div class="form-group col-md-12 {{ Helpers::inputError($errors, 'route_id') }}">
      <div class="col-md-12">
          <span class='help-inline'>
            {{ $errors->first('route_id') }}
          </span>
        @include('admin.process.trips.routes_list', array('resource' => $schedule, 'options' => $options))
        {{ Form::hidden('route_id', $schedule->route_id) }}
      </div>
    </div>

  </div>

  <span class='notify-success-text hidden'> Schedule is successfully {{$schedule->exists() ? 'updated' : 'created'}}. </span>

{{Form::close()}}


<script>
  $(document).ready(function(){
    $('form#schedule-form').find('select').each(function(){
      if ( !$(this).hasClass('selectized') )
        {
          var select = $(this);
          initSelectize($(this), {create:false  });
        }
    });
    $('.input-datetime-only-hour').datetimepicker({
        weekStart: 0,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 2,
        forceParse: 0
    });

    $('.datetimepicker-hours').find('thead tr th').addClass('visibility-hidden');

    $(document).on('click', '.select-trip-option', function(e){

      var form = $('form.schedule-form');

      if (form.length)
      {
        var route_id = form.find('input[name=route_id]');
        if (route_id.length){
          route_id.val($(this).data('value'));
          update_button_selected($(this));
        }
      }
    });

  });
</script>