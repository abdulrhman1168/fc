@extends('layouts.main.index')

@section('page')
<div class="panel panel-default">
    <div class="panel-heading">معلومات المتقدم</div>

    <div class="panel-body">

        <table class="table table-bordered table-striped table-condensed flip-content">
            <thead class="flip-content">
                <tr>
                    <th colspan="4">بيانات المتقدم</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>الإسم </td>
                    <td>{{ $memberData->name }}</td>
                    <td>الايميل </td>
                    <td>{{ $memberData->email }}</td>
                </tr>
                <tr>
                    <td>رقم الهوية</td>
                    <td>{{ $memberData->id_no }}</td>
                    <td>رقم الجوال</td>
                    <td>{{ $memberData->mobile }}</td>
                    
                </tr>
                <tr>
               
            </tbody>
        </table>

    
    

    </div>

    <div class="panel-footer">
        <a href="{{url('core/members')}}" class="btn btn-default">رجوع</a>
        <a href="{{url('core/members')}}" class="btn btn-default">تحديث</a>
    </div>

</div>
@endsection