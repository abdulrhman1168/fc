@extends('layouts.main.index')

@section('page')


  
<div class="row">

    {!! Form::open(['route' => 'players/store','class'=>'form-horizontal','files'=>true ]) !!}
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-user font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">إضافة لاعب جديد  </span>
                    </div>
                    
                </div>
                <div class="portlet-body form">
                   
                        <div class="form-body">

                            <div class="form-group">
                                <label>اسم اللاعب</label>
                                <div class="input-group input-icon-lg">
                                    <span class="input-group-addon">
                                        <i class="fa fa-sort-numeric-asc"></i>
                                    </span>
                                    <input type="text" name ="user_empno" class="form-control input-lg" placeholder="اسم اللاعب "> </div>
                            </div>
                            @if ($errors->has('user_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user_name') }}</strong>
                            </span>
                        @endif
                            <div class="form-group">
                                    <label>رقم اللاعب </label>
                                    <div class="input-group input-icon-lg">
                                        <span class="input-group-addon">
                                            <i class="fa fa-file-word-o"></i>
                                        </span>
                                        <input type="text" name ="user_name" class="form-control input-lg" placeholder="رقم اللاعب "> </div>
                                </div>

                                <div class="form-group">
                                        <label>العمر </label>
                                        <div class="input-group input-icon-lg">
                                            <span class="input-group-addon">
                                                <i class="fa fa-file-word-o"></i>
                                            </span>
                                            <input type="text" name ="user_enname" class="form-control input-lg" placeholder="العمر "> </div>
                                    </div>
        
                                    <div class="form-group">
                                            <label>الطول</label>
                                            <div class="input-group input-icon-lg">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-phone"></i>
                                                </span>
                                                <input type="text" name ="user_mobile" class="form-control input-lg" placeholder="الطول"> </div>
                                        </div>

                                        <div class="form-group">
                                                <label>الوزن</label>
                                                <div class="input-group input-icon-lg">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                    <input type="text" name ="user_mail" class="form-control input-lg" placeholder="الوزن"> </div>
                                            </div>
                                          
                                                <div class="form-group">
                                                    <label>عدد الاهداف</label>
                                                    <div class="input-group input-icon-lg">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-location-arrow"></i>
                                                        </span>
                                                        <input type="text" name ="user_address" class="form-control input-lg" placeholder="عدد الاهداف"> </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>تاريخ الإنضمام</label>
                                                    <div class="input-group input-icon-lg">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-location-arrow"></i>
                                                        </span>
                                                        <input type="text" name ="user_address" class="form-control input-lg" placeholder="تاريخ الإنضمام"> </div>
                                                </div>
                       
                          
                         
                        
                        </div>
                       
                </div>
            </div>
           
           
            <!-- END SAMPLE FORM PORTLET-->
        </div>

            </form>
    </div>


@endsection