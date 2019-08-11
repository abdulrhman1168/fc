@extends('layouts.main.index')


@section('page')
  <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-list"></i>
          <span class="caption-subject sbold uppercase">طلبات اعتماد تحديث الأبحاث</span>
        </div>
      </div>
       <table class="table table-striped panel-body">
            <thead>
                <tr>
                    <th>الرقم الوظيفي</th>
                    <th>الموظف</th>
                    <th>الدرجة العلمية</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($updateResearchs as $updateResearch)
                <tr>
                    <td>{{ $updateResearch->user_id }}</td>
                    <td>{{ $updateResearch->arabic_name }}</td>
                    <td>{{ $updateResearch->rank_desc }}</td>

                    <td>
                      @if ($updateResearch->pladge == 1)
                          {!! Form::model($updateResearch->user_id, ['method' => 'post', 'route' => ['check-updateResearch', $updateResearch->user_id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
                              {!! Form::hidden('user_id', $updateResearch->user_id) !!}
                              {!! Form::hidden('pladge', 2) !!}
                              <button type="submit" class="btn btn-success yes-no-submit-button-form" >
                              <i class="fa fa-check"></i>
                              {{ __('departmentservices::app.approve') }}
                              </button>
                          {!! Form::close() !!}
                          {!! Form::model($updateResearch->user_id, ['method' => 'post', 'route' => ['check-updateResearch', $updateResearch->user_id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
                              {!! Form::hidden('user_id', $updateResearch->user_id) !!}
                              {!! Form::hidden('pladge', 0) !!}
                              <button type="submit" class="btn btn-danger yes-no-submit-button-form" >
                              <i class="fa fa-check"></i>
                              {{ __('departmentservices::app.reject') }}
                          </button>
                          {!! Form::close() !!}

                      @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

  </div>
@endsection
