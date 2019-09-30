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
                </div>
            </div>
            <table class="table table-striped panel-body">
                <thead>
                    <tr>
                        <th>{{ __('departmentservices::permissions.employee_name') }}</th>
                        <th>{{ __('departmentservices::permissions.department_name') }}</th>
                        <th>{{ __('departmentservices::permissions.date') }}</th>
                        <th>{{ __('departmentservices::permissions.permission_type') }}</th>
                        <th>{{ __('departmentservices::permissions.permission_reason') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                    <tr id="permission-tr-id-{{ $permission->id }}">
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
                        <td>{{ $permission->reason }}</td>
                        <td>
                            <a class="btn btn-danger pull-right permission_rejected" data-permissionid="{{ $permission->id }}"><i class="fa fa-remove"></i> {{ __('departmentservices::permissions.reject_btn') }}</a>
                            <a class="btn btn-primary pull-right permission_approved" href="{{ route('permissions.approve', $permission->id) }}"><i class="fa fa-check"></i> {{ __('departmentservices::permissions.approve_btn') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</div>



<div class="modal fade" id="reject-form" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => 'permissions.reject', 'method' => 'POST', 'id' => 'form_reject_permission']) !!}
                {!! Form::hidden('permission_id', null, ['id' => 'permission_id', 'class' => 'form-control']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{ __('departmentservices::permissions.reject_permission') }}</h4>
                </div>
                <div class="modal-body">
                    {!! Form::textarea('permission_reject_reason', null, ['id' => 'permission_reject_reason', 'class' => 'form-control', 'rows' => '3', 'placeholder' => __('departmentservices::permissions.reject_reason'), 'required' => 'true']) !!}
                </div>
                <div class="modal-footer">
                    {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i> '.  __('departmentservices::permissions.save_btn'), ['type' => 'submit', 'class' => 'btn green-haze']) !!}
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
    $(".permission_approved").click(function(e) {
        $('#reject-form').hide();
        $(".alert").hide();
        var href       = $(this).attr('href');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: href,
            type: 'POST',
            data: {_token: CSRF_TOKEN },
            dataType: 'JSON',
            success: function (result) {
                if(result.alert_type == 'success') {
                    $("#permission-tr-id-" + result.data.id).hide();
                }
                $('#alert-'+ result.alert_type +' #message').text(result.message);
                $('#alert-'+ result.alert_type).slideDown();
            },
            error: function (data) {
            },
        });
        return false;
    });

    $(".permission_rejected").click(function(e) {
        $(".alert").hide();
        $("#permission_id").val($(this).data('permissionid'));
        $("#permission_reject_reason").val("");
        $('#reject-form').modal('show');
        return false;
    });

    var formID = "form#form_reject_permission";
    $(formID).ajaxForm({
        dataType: 'json',
        success: function(result) {
            $('#alert-'+ result.alert_type +' #message').text(result.message);
            $('#alert-'+ result.alert_type).slideDown();

            if(result.alert_type == 'success') {
                $("#permission-tr-id-" + result.data.id).hide();
                $('#reject-form').modal('toggle');
            }
        },
        error: function(data) {
            $.each(JSON.parse(data.responseText).errors, function( key, value) {
                $(formID + ' #' + key).parent().addClass('has-error');
                $(formID + ' #' + key).parent().find('.help-block').html('<strong>' + value + '</strong>').show();
            });
        }
    });

    </script>
@endsection
