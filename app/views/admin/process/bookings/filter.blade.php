{{ Form::open(['class' => 'form mb clearfix form-filter',
              'id' => 'bookings-search', 'method' => 'get', 'role' => 'form']) }}
    <div class="form-group">
        <div class="col-sm-6 pad-zero">
             {{Form::text('filter[code]',
                     Input::get('filter.code'),
                     ['class' => 'form-control', 'placeholder' => 'Search code']) }}
        </div>
        <div class="col-sm-2">
            {{ Form::submit('Search', array('class' => 'btn btn-default btn-block submit-form-filter')) }}
        </div>
        <div class="col-sm-2 pad-zero">
            <a href="#" class="btn btn-link" id="btnToggleAdvanceSearch">Advance Search</a>
        </div>
    </div>
{{ Form::close() }}

{{ Form::open(['class' => 'form form-horizontal clearfix hide well form-filter',
              'id' => 'formAdvanceSearch', 'method' => 'get', 'role' => 'form']) }}

    <div class="col-sm-8">

      <div class="form-group">
        {{ Form::label('filter[trip][code]', 'Trip Code', array('class' => 'col-sm-3 control-label')) }}
        <div class="col-sm-9">
          {{Form::text('filter[trip][code]',
                   Input::get('filter.trip.code'),
                   ['class' => 'form-control', 'placeholder' => 'Search trip code']) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('filter[passenger][name]', 'Passenger Name', array('class' => 'col-sm-3 control-label')) }}
        <div class="col-sm-9">
          {{Form::text('filter[passenger][name]',
                   Input::get('filter.passenger.name'),
                   ['class' => 'form-control', 'placeholder' => 'Search passenger name']) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('filter[passenger][phone]', 'Passenger Phone', array('class' => 'col-sm-3 control-label')) }}
        <div class="col-sm-9">
          {{Form::text('filter[passenger][phone]',
                   Input::get('filter.passenger.phone'),
                   ['class' => 'form-control', 'placeholder' => 'Search passenger phone number']) }}
        </div>
      </div>

    </div>

    <div class="clearfix"></div>
    <div class="col-sm-8">
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-3">
                {{ Form::submit('Search', array('class' => 'btn btn-block btn-warning submit-form-filter ', 'value' => 'search')) }}
            </div>
        </div>
    </div>

{{ Form::close() }}

<script>
    $(document).ready(function(){

      $('form#formAdvanceSearch').each(function(){
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