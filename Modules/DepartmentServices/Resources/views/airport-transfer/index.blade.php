@extends('layouts.main.index')

@section('page')

    <div class="row">
        <div class="col-md-12">

            @if(session()->has('error'))
                <div class="alert alert-danger">{{ session()->get('error') }}</div>
            @endif
            
            @if(session()->has('success'))
                <div class="alert alert-success">{{ session()->get('success') }}</div>
            @endif


            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-plane" aria-hidden="true"></i> طلبات بدل تنقل مطار
                    </div>
    
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body">
                        
                    <div class="table-scrollable">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>تاريخ الطلب</th>
                                    <th>نوع الطلب</th>
                                    <th>العام الدراسي</th>
                                    <th>الحالة</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($airportTransferOrders as $key => $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $order->order_type_text }}</td>
                                        <td>{{ optional($order->year)->name }}</td>
                                        <td>{{ $order->order_status_text }}</td>
                                        <td>
                                            <a href="{{ route('department-services.airport-transfer.show', $order->id) }}" class="btn btn-default"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
    
    
                </div>
            </div>


        </div>
    </div>

@endsection
