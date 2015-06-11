{{ Form::open(['url' => '',
     'class' => 'form form-horizontal update-data-table form-stationable',
      'id' => 'stationable-form-'.$stationable_object->id, 'method' => 'post']) }}

  <div class="form-group {{ Helpers::inputError($errors, 'station_id') }}">
    {{ Form::label('station_id', 'Station', array('class' => 'col-md-2 control-label')) }}
    <div class="col-md-10">
      {{ Form::select('station_id', $options['stations'], $stationable_object->stationed_id,
                      array('class' => 'form-control station-options', 'id' => 'station_id')) }}
      <span class='help-inline'>
        {{ $errors->first('station_id') }}
      </span>
    </div>
  </div>

  <span class='notify-success-text hidden'> Station has been changed succesfully </span>

{{Form::close()}}



<script>
    $(document).ready(function(){

      var selectized;

      $('form.form-stationable').each(function(){
        var form =$(this);
        form.find('select').each(function(){
          if ( !$(this).hasClass('selectized') )
          {
            selectized = initSelectize($(this), {create:false});
          }
        });
      });
    });
</script>