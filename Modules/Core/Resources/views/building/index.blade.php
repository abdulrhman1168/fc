@extends('layouts.main.index')

@section('page')
@if(session()->has('success'))
    <div class="alert alert-success">
        <button class="close" data-dismiss="alert"></button>
        {{ session()->get('success') }}
    </div>
@endif
<div class="portlet light bordered">
<div class="panel-heading">
      <h4>{{__('core::app.add_new_building')}}</h4>
    </div>
    <div class="portlet-body form">
        {!! Form::open(['route' => 'core.buildings.store','method' => 'post','class'=>'form-horizontal']) !!}
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">{{__('core::app.name_buildingـar')}}</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-circle" name="name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">{{__('core::app.name_buildingـen')}}</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-circle" name="name_en">
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">{{__('core::app.city')}}</label>
                  <div class="col-md-7">
                      <select name="id_city" class="form-control input-circle" >
                          @foreach ($cities as $row)
                          <option value="{{$row->id}}">{{$row->name}}</option>
                          @endforeach
                      </select>
                  </div> 
                </div>
                <div class="form-actions right">
                <button type="submit" class="btn btn-circle green">{{ __('core::app.add_new_building') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="portlet light bordered">
    <div class="panel-heading">
      <h4>{{__('core::app.buildings')}}</h4>
    </div>
    <div class="panel-heading">
      <table id="table" clase="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer">
        <thead>
          <tr>
            <th>{{__('core::app.name_buildingـar')}}</th>
            <th>{{__('core::app.name_buildingـen')}}</th>
            <th>{{__('core::app.city')}}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($buildings as $row)
            <tr>
              <th>{{$row->name}}</th>
              <th>{{$row->name_en}}</th>
              <th>{{$row->city->name}}</th>
              <th>edit</th>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>
@endsection
