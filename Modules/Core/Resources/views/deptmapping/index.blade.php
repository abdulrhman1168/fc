@extends('layouts.main.index')



@section('page')
{!! Form::open(['route'=>['deptmapping.store']]) !!}
    <table class="table" id="table">
        <thead>
            <tr>
                <td>
                    {{ __('Core::app.name') }}
                </td>
                <td>
                    {{ __('Core::app.MUDept') }}
                </td>
            </tr>
        </thead>
        <tboady>
            @foreach($hr_departments as $row)
                <tr>
                    <td>
                        {{$row->hr_departments}}: {{ $row->hr->name }}
                    </td>
                    <td>
                        {!! Form::select('row['.$row->hr_departments.']',$mu_departments,old($row->mu_departments), ['class' => 'form-control select2']) !!}
                        {{$row->mu_departments}}
                    </td>
                </tr>
            @endforeach
        </tboady>
        <tfoot>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary">{{__('Core::app.save')}}</button>
                </td>
            </tr>
        </tfoot>
    </table>
{!! Form::close() !!}
@stop


