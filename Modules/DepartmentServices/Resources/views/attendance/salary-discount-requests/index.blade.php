@extends('layouts.main.index')

@section('page')
<div class="portlet light bordered">
    <div class="portlet-title">
      <div class="caption">
        <i class="fa fa-users"></i>
        <span class="caption-subject sbold uppercase">{{ __('departmentservices::app.salary_discount_requests') }}</span>
      </div>
      <div class="actions">
            <div class="btn-group btn-group-devided" data-toggle="buttons">
                <a href="{{ route('salary-discount-requests.create') }}" class="btn btn-success">{{ __('messages.action_add')}}</a>
            </div>
      </div>
    </div>
    <div class="row">
        {!! Form::open(['route' =>  ['salary-discount-requests.index'], 'method'=>'get']) !!}
            <div class="row">
                <div class="col-md-1">
                    حالة الطلب
                </div>
                <div class="col-md-2">
                    {!! Form::select('is_closed',   [ 0 => 'مفتوح',  1 => 'مغلق'  ], old('is_closed'), ['class' => 'form-control'])!!}
                </div>
                <div class="col-md-2">
                    {!! Form::text('request_number',  old('request_number'), ['class' => 'form-control', 'placeholder' => __('departmentservices::app.request_number')])!!}
                </div>
                <div class="col-md-4">
                    {!! Form::select('user_id', ($userId ? [$userId => getUserById($userId)->user_name] : [null => null] ), $userId, ['class' => 'form-control select2-user-select', 'id' => 'select2-user-select'])!!}
                </div>
                <div class="col-md-1">
                    <a href="#" id="clear-select2-selection" class="text-success">
                            الغاء بحث الموظف
                    </a>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-circle btn-icon-only blue">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <br/>
    <table class="table table-striped panel-body delete-object-modal-table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('departmentservices::app.request_number') }}</th>
                <th>{{ __('departmentservices::app.date') }}</th>
                <th>{{ __('departmentservices::app.hijri_date') }}</th>
                <th>{{ __('departmentservices::app.month') }}</th>
                <th>{{ __('departmentservices::app.approved_status') }}</th>
                <th>{{ __('departmentservices::app.request_status') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->request_number }}</td>
                <td>{{ $request->created_at->format('Y-m-d') }}</td>
                <td>{{ $request->hijri_date }}</td>
                <td>{{ $request->month }}</td>
                <td>{{ $request->approvalStatus() }}</td>
                <td>{{ $request->is_closed ? 'مغلق' : 'مفتوح' }}</td>
                <td>
                    <a href="{{ route('salary-discount-requests.show', ['id' => $request->id]) }}" class="btn  btn-default">
                            <i class="fa fa-eye"></i>{{ __('messages.action_show') }}
                    </a>
                    @if($request->approved_by_user_id == null && $request->created_by_user_id == Auth::user()->user_id)
                    {!! Form::model($request->id, ['method' => 'delete', 'route' => ['salary-discount-requests.destroy', $request->id], 'class' =>'form-inline form-delete-modal', 'style' => 'display: inline;']) !!}
                            {!! Form::hidden('id', $request->id) !!}
                            <button type="submit" class="btn btn-danger yes-no-submit-button-form" >
                            <i class="fa fa-trash-o"></i>
                            {{ __('messages.action_delete') }}
                            </button>
                    {!! Form::close() !!}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $requests->render() !!}
</div>
@endsection