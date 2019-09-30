@extends('layouts.main.index')

@section('page')
  <div class="note note-info">
        <h2>{{ __('myservices::app.show_travel_title') }} {{$ticket->id}}</h2>
  </div>

  <div class="table-scrollable">
    <table class="table table-bordered table-hover">
      <tr>
        <th>{{ __('myservices::app.form_department')}}</th>
        <td>{{$ticket->collage}}</td>
        <th>{{ __('myservices::app.job')}}</th>
        <td>{{$ticket->job}}</td>
      </tr>
      <tr>
        <th>{{ __('myservices::app.rank')}}</th>
        <td>{{$ticket->degree}}</td>
        <th>{{ __('myservices::app.purpose')}}</th>
        <td>{{$ticket->purpose}}</td>
      </tr>
      <tr>
        <th>{{ __('myservices::app.itinerary')}}</th>
        <td>{{$ticket->path}}</td>
        <th>{{ __('myservices::app.decision_number')}}</th>
        <td>{{$ticket->decision_number}}</td>
      </tr>
      <tr>
        <th>{{ __('myservices::app.flight_class')}}</th>
        <td>{{$ticket->class}}</td>
        <th>{{ __('myservices::app.form_type')}}</th>
        <td>{{$ticket->type}}</td>
      </tr>
      <tr>
        <th>{{ __('myservices::app.attach')}}</th>
        <td><a href="{{ asset('/uploads/travelAllowance')}}{{'/'.$ticket->attach}}">{{ __('myservices::app.attach')}}</a></td>
      </tr>
    </table>
  </div>
  <h3 class="form-section"> {{ __('myservices::app.escorts')}}</h3>
  <div class="table-scrollable">
    <table class="table table-hover list-escorts" id="list-escorts">
      <thead>
          <tr>
              <th>{{ __('messages.general_name')}}</th>
              <th>{{ __('myservices::app.id_number')}}</th>
              <th>{{ __('myservices::app.ticket_category')}}</th>
              <th>{{ __('myservices::app.relationship')}}</th>
              <th>{{ __('myservices::app.date_of_birth')}}</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($escorts as $key => $value)
            <tr>
              @foreach ($value as $k =>$v)
                <td>{{$v}}</td>
              @endforeach
            </tr>
          @endforeach
      </tbody>
    </table>
  </div>
  <div class="form-actions">
      <a href="{{route('myservices.travelAllowance') }}" class="btn default">{{__('messages.URLback')}}</a>
  </div>
@endsection
