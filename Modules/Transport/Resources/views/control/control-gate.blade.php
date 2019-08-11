@extends('layouts.main.index')



@section('page')

<div class="portlet light bordered">
    <div class="portlet-title">
      <div class="caption">
        <i class="fa fa-users"></i>
        <span class="caption-subject sbold uppercase">فترات التسجيل</span>
      </div>
      <div class="actions">
        <div class="btn-group btn-group-devided" data-toggle="buttons">
            <a href="{{ route('trans.add-registration-period') }}" class="btn btn-success">اضافة فترة تسجيل</a>
        </div>
      </div>
    </div>
    <table id="table-ajax" class="table panel-body delete-object-modal-table"
    data-url="/transport/control/control-gate"
    data-fields='[
        {"data": "year","title":"العام الدراسي","searchable":"true"},
        {"data": "start_date","title":"تاريخ البداية","searchable":"false"},
        {"data": "end_date","title":"تاريخ النهاية","searchable":"false"}
    ]'>
  </table>
</div>

@endsection