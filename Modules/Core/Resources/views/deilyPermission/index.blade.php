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
      <h4>إضافة موظف جديد للحركة اليومية</h4>
    </div>
    <div class="portlet-body form">
 
        {!! Form::open(['route' => 'core.deilyPermission.store', 'method' => 'POST', 'id' => 'add_employee_form']) !!}
        <div class="portlet-body form">
            <div class="form-horizontal form-bordered">

        
                    <div class="form-group">
                        {!! Form::label('user_mail', 'الإيميل الجامعي', ['class' => 'col-md-2 add_space_at_top']) !!}
                        <div class="col-md-4">
                            {!! Form::text('', NULL, ['id' => 'user_mail', 'class' => 'form-control']) !!}
                            {!! Form::hidden('user_id', NULL, ['id' => 'user_id', 'class' => 'form-control']) !!}
                            <span class="help-block"></span>
                            <br><a id="check_employee_id"><i class="fa fa-search" aria-hidden="true"></i> {{ 'تحقق' }}</a>
                        </div>
                        <div class="col-md-4" id="employee_name">
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('perm_id', 'الكلية', ['class' => 'col-md-2 add_space_at_top']) !!}
                        <div class="col-md-4">
                            {!! Form::select('perm_id', $real_dept_code, NULL, ['id' => 'real_dept_code', 'class' => 'form-control select2']) !!}
                            
                            
                        </div>
                        
                    </div>

                    
                    <div class="form-group">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-10">
                            <div class="minicolors minicolors-theme-bootstrap minicolors-position-top minicolors-position-right">
                                {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i> ' . 'إضافة', ['type' => 'submit', 'class' => 'btn green-haze', 'id' => 'btn', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
        </form>
    </div>
</div>

<div class="portlet light bordered">
    <div class="panel-heading">
      <h4>الموظفين الممنوحه لهم صلاحية الحركة اليومية حسب الكلية</h4>
    </div>
    <div class="panel-heading">
      <table id="table" clase="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer">
        <thead>
          <tr>
            <th>#</th>
            <th>اسم الموظف</th>
            <th>الكلية</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($Permission as $row)
            <tr>
              <th>{{$row->id}}</th>
              <th>{{optional (Modules\Auth\Entities\Core\User::find($row->user_id))->user_name}}</th>
              <th>
                @if ($row->perm_id == 9999) 
                  جميع الكليات
                
                @endif
                {{optional (Modules\Core\Entities\Core\HRDepartment::find($row->perm_id))->name}}</th>
              <th><a href="{{ route('core.deilyPermission.destroy',$row->id ) }}" class="btn btn-outline btn-md red  " onclick="return confirm('هل انت متاكد من الحذف ؟')">
                  <i class="fa fa-times"></i> <span>حذف</span>
              </a></th>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>
@endsection
@section('scripts_2')
{!! Html::script('assets/js/jquery.form.min.js') !!}
<script>



$('#add_employee_form #check_employee_id').click(function() {
        var user_mail = $("#add_employee_form #user_mail").val();
        $('#add_employee_form #btn').attr("disabled", 'true');
        $.get("deilyPermission/getEmployeeData/" + user_mail, function(data, status){
            if(data['alert_type'] == 'success') {
                $('#add_employee_form #btn').removeAttr("disabled");
                $('#add_employee_form #user_id').val(data['user_id']);
            }
            else {
                $('#add_employee_form #btn').attr("disabled", 'true');
            }
            $('#add_employee_form #employee_name').html('<center>' + data['message'] + '</center>');
        });
    });

</script>

@endsection
