@if($request->current_step >= 5)
<div class="portlet-title">
        <div class="caption">
        <i class="fa fa-list"></i>
       {{ __('myservices::app.deanship_staff_salary') }}
      </div>
</div>
@endif

@if($request->current_step > 5)
<div class="row">
        <div class="col-md-12">
               <table class="table table-striped panel-body">
                   <tbody>
                       <tr>
                           <th>تاريخ التوقيع بالهجري</th>
                           <td>{{ $request->step_6_approval_date }}</td>
                       </tr>
                       <tr>
                            <th>إسم الموظف المختص</th>
                            <td>{{ $request->step6Approval->arabic_name }}</td>
                        </tr>
                   </tbody>
               </table>
        </div>
</div>

@endif

@if($request->current_step == 5 && $request->isSalaryApproveAbility(Auth::user()))
    {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.step7-housing-allowance-request', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
        {!! Form::hidden('approved', 1) !!}
        <button type="submit" class="btn btn-success yes-no-submit-button-form" >
        <i class="fa fa-check"></i>
        {{ __('departmentservices::app.approve') }}
        </button>
    {!! Form::close() !!}
    <br/><br/>
@endif