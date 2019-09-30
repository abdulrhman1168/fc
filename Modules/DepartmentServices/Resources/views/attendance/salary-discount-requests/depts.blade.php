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
    <table class="table table-striped panel-body delete-object-modal-table">
        <thead>
            <tr>
                <th>اسم الادارة</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
          <?php
            $depts = array() ;
          foreach ($requests as $row)
          {
            $depts [] =  $row->DEPARTMENT_ID ;

          }

          print_r($depts);



/*
           ?>
        @foreach($variable as $key => $value)



       <td>

       </td>


            <td>
              <a href="{{ route('salary-discount-requests.show', ['id' => $request->id]) }}" class="btn  btn-default">
                      <i class="fa fa-eye"></i>{{ __('messages.action_show') }}
              </a>
            </td>

          @endforeach
        </tbody>

    </table>
<?php */ ?>
    {!! $requests->render() !!}
</div>
@endsection
