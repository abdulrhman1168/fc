@extends('layouts.main.index')

@section('page')
<div class="row">

    <div class="col-md-12">

        <div id="alert-success" class="custom-alerts alert alert-success fade in" @if(!Session::has('success')) style="display:none" @endif>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

            <i class="fa fa-check" aria-hidden="true"></i>
            <span id="message">{{ Session::get('success') }}</span>
        </div>

        <div id="alert-danger" class="custom-alerts alert alert-danger fade in" @if(!Session::has('error')) style="display:none" @endif>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

            <i class="fa fa-times" aria-hidden="true"></i>
            <span id="message">{{ Session::get('error') }}</span>
        </div>


        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-users"></i>
                    <span class="caption-subject sbold uppercase">{{ __('departmentservices::permissions.permissions_requests') }}</span>
                </div>
                <div class="actions">
                        <a class="btn btn-primary pull-right" href="{{ route('permissions.administrator.add') }}"><i class="fa fa-edit"></i> {{ __('departmentservices::permissions.add_btn') }}</a>
                </div>
            </div>
            
            {{ Form::open(['route' => 'permissions.administrator.display-all-permissions', 'method' => 'get']) }}
                <div class="form-group">
                    {{ Form::text('search', old('search'), ['class' => 'form-control', 'placeholder' => 'البحث ..']) }}
                </div>
            {{ Form::close() }}

            <hr>

            <table class="table table-striped panel-body">
                <thead>
                    <tr>
                        <th>{{ __('departmentservices::permissions.employee_id') }}</th>
                        <th>{{ __('departmentservices::permissions.employee_name') }}</th>
                        <th>{{ __('departmentservices::permissions.department_name') }}</th>
                        <th>{{ __('departmentservices::permissions.date') }}</th>
                        <th>{{ __('departmentservices::permissions.permission_type') }}</th>
                        <th>{{ __('departmentservices::permissions.status') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                    <tr id="permission-tr-id-{{ $permission->id }}">
                        <td>{{ $permission->employee_number }}</td>
                        <td>
                            @if(Lang::Locale() == 'ar')
                                {{ $permission->arabic_name }}
                            @else
                                {{ $permission->english_name }}
                            @endif
                        </td>
                        <td>{{ $permission->department_name }}</td>
                        <td>{{ $permission->from_date->format('Y-m-d') }}</td>
                        <td>{{ $permission->type_name }}</td>
                        <td>{{ $permission->status_text }}</td>
                        <td>
                            <a class="btn btn-danger pull-right delete_permission" data-permissionid="{{ $permission->id }}"><i class="fa fa-remove"></i> {{ __('departmentservices::permissions.delete_btn') }}</a>
                            <a class="btn btn-primary pull-right" href="{{ route('permissions.administrator.edit', $permission->id) }}"><i class="fa fa-edit"></i> {{ __('departmentservices::permissions.edit_btn') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $permissions->render() !!}
        </div>

    </div>
</div>



<div class="modal fade" id="delete-form" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => 'permissions.administrator.delete', 'method' => 'POST', 'id' => 'form_delete_permission']) !!}
                {!! Form::hidden('permission_id', null, ['id' => 'permission_id', 'class' => 'form-control']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{ __('departmentservices::permissions.reject_permission') }}</h4>
                </div>
                <div class="modal-body">
                    هل انت متأكد من حذف الإستئذان؟
                </div>
                <div class="modal-footer">
                    {!! Form::button('<i class="fa fa-remove" aria-hidden="true"></i> '.  __('departmentservices::permissions.delete_btn'), ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal"><i class="fa fa-times"></i> {{  __('departmentservices::permissions.cancel_btn') }}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts_2')
    {!! Html::script('assets/js/jquery.form.min.js') !!}
    <script>

    
    $(".delete_permission").click(function(e) {
        $(".alert").hide();
        $("#permission_id").val($(this).data('permissionid'));
        $("#").val("");
        $('#delete-form').modal('show');
        return false;
    });
    
    var formID = "form#form_delete_permission";
    $(formID).ajaxForm({
        dataType: 'json',
        success: function(result) {
            $('#alert-'+ result.alert_type +' #message').text(result.message);
            $('#alert-'+ result.alert_type).slideDown();

            if(result.alert_type == 'success') {
                $("#permission-tr-id-" + result.data.id).hide();
            }
            $('#delete-form').modal('toggle');
        },
        error: function(data) {
            $.each(JSON.parse(data.responseText).errors, function( key, value) {
                $(formID + ' #' + key).parent().addClass('has-error');
                $(formID + ' #' + key).parent().find('.help-block').html('<strong>' + value + '</strong>').show();
            });
            $('#delete-form').modal('toggle');
        }
    });

    </script>
@endsection
