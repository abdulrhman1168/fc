@extends('layouts.main.index')

@section('page')

    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-plane" aria-hidden="true"></i> عرض الطلب
                    </div>
    
                    <div class="actions">
                        <a href="{{ route('department-services.airport-transfer.index') }}" class="btn green-haze"><i class="fa fa-chevron-right"></i> <span> رجوع</span></a>
                    </div>
                </div>
                <div class="portlet-body">
                    
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2">تفاصيل الطلب</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <th>تاريخ الطلب</th>
                                    <td>{{ $airportTransferOrder->created_at->format('Y-m-d') }}</td>
                                    
                                    <th>نوع الطلب</th>
                                    <td>{{ $airportTransferOrder->order_type_text }}</td>
                                </tr>

                                <tr>
                                    <th>العام الدراسي</th>
                                    <td>{{ optional($airportTransferOrder->year)->name }}</td>
                                    
                                    <th>حالة الطلب</th>
                                    <td>{{ $airportTransferOrder->order_status_text }}</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>


                    @if(in_array($airportTransferOrder->order_type, [0,1]))
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>تفاصيل رحلة الذهاب</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr class="active">
                                                <td colspan="6">
                                                    الذهاب للمطار بتاريخ: {{ $airportTransferOrder->going_date->format('d-m-Y') }}
                                                </td>
                                            </tr>

                                            <tr class="active">
                                                <th>م</th>
                                                <th class="col-sm-3"><i class="fa fa-male"></i> الاسم</th>
                                                <th class="col-sm-2"><i class="fa fa-calendar"></i> تاريخ الميلاد</th>
                                                <th class="col-sm-2"><i class="fa fa-link"></i> صلة القرابة</th>
                                                <th class="col-sm-3"><i class="fa fa-plane"></i> طريق السفر</th>
                                                <th class="col-sm-2"><i class="fa fa-picture-o"></i> صورة الجواز</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($goingTripPersons as $personKey => $personData)
                                                <tr>
                                                    <td>{{ ++$personKey }}</td>
                                                    <td>{{ $personData->name }}</td>
                                                    <td>{{ $personData->birthday }}</td>
                                                    <td>{{ $personData->relative_relation_text }}</td>
                                                    <td>من: {{ optional($airportTransferOrder->goingWay)->name }} - الى: الرياض</td>
                                                    <td><a href="{{ route('department-services.airport-transfer.show-passport', [$airportTransferOrder->id, $personData->passport_img]) }}" target="_blank">عرض</a></td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>

                                </tr>
                                
                            </tbody>
                        </table>
                    @endif

                    @if(in_array($airportTransferOrder->order_type, [0,2]))
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>تفاصيل رحلة العودة</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr class="active">
                                                <td colspan="6">
                                                    العودة من المطار بتاريخ: {{ $airportTransferOrder->coming_date->format('d-m-Y') }}
                                                </td>
                                            </tr>

                                            <tr class="active">
                                                <th>م</th>
                                                <th class="col-sm-3"><i class="fa fa-male"></i> الاسم</th>
                                                <th class="col-sm-2"><i class="fa fa-calendar"></i> تاريخ الميلاد</th>
                                                <th class="col-sm-2"><i class="fa fa-link"></i> صلة القرابة</th>
                                                <th class="col-sm-3"><i class="fa fa-plane"></i> طريق السفر</th>
                                                <th class="col-sm-2"><i class="fa fa-picture-o"></i> صورة الجواز</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($comingTripPersons as $personKey => $personData)
                                                <tr>
                                                    <td>{{ ++$personKey }}</td>
                                                    <td>{{ $personData->name }}</td>
                                                    <td>{{ $personData->birthday }}</td>
                                                    <td>{{ $personData->relative_relation_text }}</td>
                                                    <td>من: الرياض - الى: {{ optional($airportTransferOrder->comingWay)->name }}</td>
                                                    <td><a href="{{ route('department-services.airport-transfer.show-passport', [$airportTransferOrder->id, $personData->passport_img]) }}" target="_blank">عرض</a></td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>

                                </tr>
                                
                            </tbody>
                        </table>
                    @endif


                    @if($airportTransferOrder->order_status != 7)
                        {!! Form::open(['route' => ['department-services.airport-transfer.update', $airportTransferOrder->id], 'method' => 'PUT']) !!}
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>اتخاذ إجراء</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>{!! Form::select('actions', $orderActions, NULL, ['class' => 'form-control']) !!}</td>
                                    </tr>

                                    <tr>
                                        <td>
                                            {!! Form::textarea('note', NULL, ['class' => 'form-control', 'rows' => '3', 'placeholder' => 'الملاحظات']) !!}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ Form::button('<i class="fa fa-check"></i> حفظ', ['class' => 'btn green-haze', 'type' => 'submit']) }}</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        {!! Form::close() !!}
                    @endif

                    <div class="form-group">
                        <div class="mt-checkbox-list">
                            <label class="mt-checkbox mt-checkbox-outline"> امل صرف مستحقاتي عن بدل تنقل المطار وللمرافقين معي وذلك حسب الموضح اعلاه حيث انه لم يسبق لي وللمرافقين وللمحرم الصرف أو التعويض عنها من أي جهة كانت، واقر بأن البيانات الموضحة اعلاه صحيحة وتحت مسؤوليتي علما بأن محرمي الرسمي.
                                {{ Form::checkbox('need_receivables', '1', $airportTransferOrder->need_receivables, ['id' => 'need_receivables', 'disabled' => true]) }}
                                <span></span>
                            </label>
                        </div>
                    </div>


                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="3">الاجراءات المتخذة</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($airportTransferOrder->workflows as $key => $workflow)
                                <tr class="active">
                                    <td>من: {{ $workflow->employeeObject->arabic_name }}</td>
                                    <td>الإجراء: {{ $workflow->status_text }}</td>
                                    <td>التاريخ: {{ $workflow->created_at->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">{{ $workflow->action_reason }}</td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    


                </div>
            </div>


        </div>
    </div>

@endsection