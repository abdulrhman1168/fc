@extends('layouts.main.index')

@section('page')

    <div class="row">
        <div class="col-md-12">

            @if(session()->has('error'))
                <div class="alert alert-danger">{{ session()->get('error') }}</div>
            @elseif(session()->has('success'))
                <div class="alert alert-success">{{ session()->get('success') }}</div>
            @endif

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-flag-o" aria-hidden="true"></i> التفويضات السارية
                    </div>

                    <div class="actions">
                        <a href="{{ route('authorization.create') }}" class="btn green-haze"><i aria-hidden="true" class="fa fa-plus"></i> انشاء تفويض جديد</a>
                    </div>
                </div>
                <div class="portlet-body">
                    
                    
                    <div class="table-scrollable">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>اسم الموظف</th>
                                    <th>حالة التفويض</th>
                                    <th>تاريخ التفويض</th>
                                    <th>مدة التفويض  بالأيام</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($currentAuthorizationEmployees as $authorization)
                                    <tr>
                                        <td>{{ $authorization->authorizedEmployee->arabic_name }}</td>
                                        <td>{{ $authorization->authorization_status }}</td>
                                        <td>{{ $authorization->from_date->format('Y-m-d') . ' - ' . $authorization->to_date->format('Y-m-d') }}</td>
                                        <td>{{ $authorization->different_between_from_to_dates_in_days }}</td>
                                        <td>
                                            <div class="btn-group pull-right">
                                                <a href="{{ route('authorization.show', $authorization->id) }}" class="btn btn-default" title="التفاصيل"><i class="fa fa-info" aria-hidden="true"></i></a>
                                                <a href="{{ route('authorization.remove', $authorization->id) }}" class="btn btn-danger" style="margin-right:5px" title="الغاء التصريح"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </div>
                                        </td>
                                    </tr>  
                                @endforeach

                                @if($currentAuthorizationEmployees->count() == 0)
                                    <tr>
                                        <td colspan="5"><center>لا يوجد تفويضات</center></td>
                                    </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>


            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-flag-o" aria-hidden="true"></i> التفويضات
                    </div>
    
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body">
                        
                        
                    <div class="table-scrollable">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>اسم الموظف</th>
                                    <th>حالة التفويض</th>
                                    <th>تاريخ التفويض</th>
                                    <th>مدة التفويض بالأيام</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
    
                                @foreach ($otherAuthorizationEmployees as $authorization)
                                    <tr>
                                        <td>{{ $authorization->authorizedEmployee->arabic_name }}</td>
                                        <td>{{ $authorization->authorization_status }}</td>
                                        <td>{{ $authorization->from_date->format('Y-m-d') . ' - ' . $authorization->to_date->format('Y-m-d') }}</td>
                                        <td>{{ $authorization->different_between_from_to_dates_in_days }}</td>
                                        <td>
                                            <div class="btn-group pull-right">
                                                <a href="{{ route('authorization.show', $authorization->id) }}" class="btn btn-default" title="التفاصيل"><i class="fa fa-info" aria-hidden="true"></i></a>

                                                @if($authorization->auth_status == 0)
                                                    <a href="{{ route('authorization.remove', $authorization->id) }}" class="btn btn-danger" style="margin-right:5px" title="الغاء التصريح"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                @endif 

                                            </div>
                                        </td>
                                    </tr>  
                                @endforeach

                                @if($otherAuthorizationEmployees->count() == 0)
                                    <tr>
                                        <td colspan="5"><center>لا يوجد تفويضات</center></td>
                                    </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
    
                    {!! $otherAuthorizationEmployees->links() !!}
    
                </div>
            </div>


        </div>
    </div>

@endsection
