@extends('layouts.main.index')

@section('page')
@if(session()->has('success'))
    <div class="alert alert-success">
        <button class="close" data-dismiss="alert"></button>
        {{ session()->get('success') }}
    </div>
@endif
    <div class="row">
      <div class="col-md-12">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light portlet-fit bordered">
              <div class="portlet-title">
                  <div class="col-md-6">
                    <div class="caption">
                        <span class="caption-subject font-blue sbold ">
                          <h3> طلبات تنظيم المناسبات </h3>
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6">

                  </div>
              </div>
              <div class="portlet-body">
                @if ($requests == null)
                لا يوجد لديك طلبات
                @else
                  <table class="table table-striped table-bordered table-advance table-hover">
                    <tr>
                      <td>رقم الطلب </td>
                      <td>مقدم الطلب </td>
                      <td>حالة الطلب </td>
                      <td>موقع المناسبة </td>
                      <td> </td>
                    </tr>
                    @foreach($requests as $row)
                      <tr>
                        <td>{{$row->id}}</td>
                        <td>{{$row->user->user_name}}</td>
                        <td>{{$row->statu->name_ar}}</td>
                        <td>{{$row->minePlace()->place->name_ar}}</td>
                        <td>
                          <a href='{!! route('prmuevents.show', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                <i class="fa fa-edit"></i> {{__('messages.details')}} </a>
                          @if($row->status == 1)
                              @if($row->level == 3)
                              <a href='{!! route('PrmuEvents.inform', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                    <i class="fa fa-edit"></i> اعتماد والرفع للاحاطة  </a>
                              @else
                              <a href='{!! route('PrmuEvents.approvalfrommanagerdept', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                    <i class="fa fa-edit"></i> اعتماد والرفع بطلب الموافقة  </a>
                              @endif
                              <a href='{!! route('PrmuEvents.re', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                    <i class="fa fa-edit"></i>تعاد </a>
                          @elseif(in_array($row->status , array(2, 3)))
                              @if($row->conflict == 1)
                                <a href='{!! route('PrmuEvents.override', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                    <i class="fa fa-edit"></i>تجاوز التعارض </a>
                                <a href='{!! route('PrmuEvents.changeTime', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                      <i class="fa fa-edit"></i>إعادة لتغيير الوقت </a>
                              @elseif(in_array($row->sponsor , array(1, 2)))
                                  <a href='{!! route('PrmuEvents.gotoRector', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                      <i class="fa fa-edit"></i>تحال لمكتب مدير الجامعة </a>
                                  <a href='{!! route('PrmuEvents.reCheck', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                      <i class="fa fa-edit"></i>تعاد للتعديل</a>
                              @elseif((in_array($row->sponsor , array(3,4,5))) AND (in_array(Auth::user()->department()->id , array(11,12,13))))
                                  <a href='{!! route('PrmuEvents.approvalAgent', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                      <i class="fa fa-edit"></i>موافقة من الوكيل  </a>
                                  <a href='{!! route('PrmuEvents.refusalAgent', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                      <i class="fa fa-edit"></i>رفض من الوكيل </a>
                              @endif
                          @elseif($row->status == 7 AND (Auth::user()->department()->id == 1))
                              <a href='{!! route('PrmuEvents.approvalRector', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                  <i class="fa fa-edit"></i>موافقة مدير الجامعة </a>
                              <a href='{!! route('PrmuEvents.refusalRector', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                  <i class="fa fa-edit"></i>رفض من مدير الجامعة </a>
                          @elseif(in_array($row->status , array(8, 10)) AND (in_array(Auth::user()->department()->id , array(1,11,12,13))))
                            <a href='{!! route('PrmuEvents.cancellation', $row->id) !!}' class="btn btn-outline btn-circle btn-sm purple">
                                <i class="fa fa-edit"></i>رفض بعد الاعتماد </a>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </table>
                @endif
              </div>
          </div>
      </div>
  </div>
@endsection
