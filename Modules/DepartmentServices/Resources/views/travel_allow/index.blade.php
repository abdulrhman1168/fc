@extends('layouts.main.index')

@section('page')
@if(session()->has('success'))
    <div class="alert alert-success">
        <button class="close" data-dismiss="alert"></button>
        {{ session()->get('success') }}
    </div>
@endif

    <div class="note note-info">
      <div class="row">
        <div class="col-md-11">
          <h2>طلبات اوامر الاركاب </h2>
        </div>
        <div class="col-md-1">

        </div>
      </div>
    </div>

    <div class="table-scrollable">
      <table class="table table-bordered table-hover">
        <thead>
        <tr>
          <td>الاسم </td>
          <td>{{ __('myservices::app.request_id') }}</td>
          <td>{{ __('myservices::app.request_route') }}</td>
          <td>{{ __('myservices::app.request_status') }}</td>
          <td>{{ __('myservices::app.request_status') }}</td>
          <td></td>
        </tr>
      </thead>
      <tbody>
        
        @foreach($ticket as $row)
        <tr>
          <td>{{$row->name}}</td>
          <td>{{$row->id}}</td>
          <td>{{$row->path}}</td>
          <td>{{date('Y/m/d', strtotime($row->start_date))}}</td>
          <td>{{date('Y/m/d', strtotime($row->return_date))}}</td>
          <td>
            <a href='{!! route('myservices.travelAllowance.show', $row->id) !!}' class="btn purple mt-ladda-btn ladda-button btn-circle btn-outline">
                <i class="fa fa-edit"></i> {{__('messages.details')}} </a>
            <a href='{!! route('department-services.travelAllowance.approval', $row->id) !!}' class="btn green mt-ladda-btn ladda-button btn-circle btn-outline">
                 اعتماد </a>
            <a href='{!! route('department-services.travelAllowance.notApproval', $row->id) !!}' class="btn red mt-ladda-btn ladda-button btn-circle btn-outline">
              رفض الاعتماد  </a>
          </td>
        </tr>
        @endforeach
      </tbody>
</table>
</div>
@endsection
