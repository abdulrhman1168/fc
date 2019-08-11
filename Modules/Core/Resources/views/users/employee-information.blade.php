@extends('layouts.main.index')

@section('page')
<div class="panel panel-default">
    <div class="panel-heading">معلومات الموظف</div>

    <div class="panel-body">

        <table class="table table-bordered table-striped table-condensed flip-content">
            <thead class="flip-content">
                <tr>
                    <th colspan="4">بيانات الموظف</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>الإسم بالعربي</td>
                    <td>{{ $userData->user_name }}</td>
                    <td>الإسم بالإنجليزي</td>
                    <td>{{ $userData->user_enname }}</td>
                </tr>
                <tr>
                    <td>رقم الهوية</td>
                    <td>{{ $userData->user_idno }}</td>
                    {{-- <td>رقم الوظيفي</td>
                    <td>{{ $employeeData->employee_id }}</td> --}}
                    <td>رقم الجوال</td>
                    <td>{{ $userData->user_mobile }}</td>
                </tr>
                <tr>
                    
                    <td>البريد الإلكتروني</td>
                    <td>{{ $userData->user_mail }}</td>
                </tr>
                {{-- <tr>
                    <td>الوظيفة</td>
                    <td colspan="3">{{ $employeeData->job_desc }}</td>
                </tr> --}}
            </tbody>
        </table>

    
        @if($departmentsData)
        <table class="table table-bordered table-striped table-condensed flip-content">
            <thead class="flip-content">
                <tr>
                    <th colspan="6">بيانات الإدارة</th>
                </tr>
            </thead>
            <tbody>
                @foreach(array_reverse($departmentsData) as $departemt)
                <tr>
                    <td>الإدارة</td>
                    <td>{{ $departemt->name_ar }}</td>
                    
                    <td>رقم الإدارة</td>
                    <td>{{ $departemt->id }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>

    <div class="panel-footer">
        <a href="{{url('core/users')}}" class="btn btn-default">رجوع</a>
    </div>

</div>
@endsection