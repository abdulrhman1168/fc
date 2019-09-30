@extends('layouts.main.index')

@section('page')
  
<div class="row">

    {!! Form::open(['route' => 'employees/store','class'=>'form-horizontal','files'=>true ]) !!}
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-user font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">البيانات الشخصية للموظف</span>
                    </div>
                    
                </div>
                <div class="portlet-body form">
                   
                        <div class="form-body">

                            <div class="form-group">
                                <label>رقم الموظف</label>
                                <div class="input-group input-icon-lg">
                                    <span class="input-group-addon">
                                        <i class="fa fa-sort-numeric-asc"></i>
                                    </span>
                                    <input type="text" name ="user_empno" class="form-control input-lg" placeholder="رقم الموظف"> </div>
                            </div>
                            @if ($errors->has('user_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user_name') }}</strong>
                            </span>
                        @endif
                            <div class="form-group">
                                    <label>الإسم بالعربي</label>
                                    <div class="input-group input-icon-lg">
                                        <span class="input-group-addon">
                                            <i class="fa fa-file-word-o"></i>
                                        </span>
                                        <input type="text" name ="user_name" class="form-control input-lg" placeholder="الإسم بالعربي"> </div>
                                </div>

                                <div class="form-group">
                                        <label>الإسم بالانجليزي</label>
                                        <div class="input-group input-icon-lg">
                                            <span class="input-group-addon">
                                                <i class="fa fa-file-word-o"></i>
                                            </span>
                                            <input type="text" name ="user_enname" class="form-control input-lg" placeholder="الإسم بالانجليزي"> </div>
                                    </div>
        
                                    <div class="form-group">
                                            <label>هاتف</label>
                                            <div class="input-group input-icon-lg">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-phone"></i>
                                                </span>
                                                <input type="text" name ="user_mobile" class="form-control input-lg" placeholder="هاتف"> </div>
                                        </div>

                                        <div class="form-group">
                                                <label>الإيميل</label>
                                                <div class="input-group input-icon-lg">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                    <input type="text" name ="user_mail" class="form-control input-lg" placeholder="الإيميل"> </div>
                                            </div>
                                            <div class="form-group">
                                                    <label>العنوان</label>
                                                    <div class="input-group input-icon-lg">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-location-arrow"></i>
                                                        </span>
                                                        <input type="text" name ="user_address" class="form-control input-lg" placeholder="العنوان"> </div>
                                                </div>
                       
                          
                         
                        
                        </div>
                       
                </div>
            </div>
           
           
            <!-- END SAMPLE FORM PORTLET-->
        </div>

        <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase"> بياتات الحالة الاجتماعية  </span>
                        </div>
                        
                    </div>
                    <div class="portlet-body form">
                      
                            <div class="form-body">
    
                                <div class="form-group">
                                    <label>تاريخ الميلاد </label>
                                    <div class="input-group input-icon-lg">
                                        <span class="input-group-addon">
                                            <i class="fa fa-birthday-cake"></i>
                                        </span>
                                        <input type="text" name ="" class="form-control input-lg" placeholder="تاريخ الميلاد "> </div>
                                </div>
    
                                <div class="form-group">
                                        <label>محل الميلاد </label>
                                        <div class="input-group input-icon-lg">
                                            <span class="input-group-addon">
                                                <i class="fa fa-map"></i>
                                            </span>
                                            <input type="text" name ="user_birthday" class="form-control input-lg" placeholder="محل الميلاد "> </div>
                                    </div>
    
                                   <div class="form-group">
                                    <label>النوع</label>
                                    <select name ="user_sex" class="form-control">
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                        <option>Option 4</option>
                                        <option>Option 5</option>
                                    </select>
                                </div>
            
                                <div class="form-group">
                                        <label>الجنسية</label>
                                        <select name ="user_nat" class="form-control">
                                            <option>Option 1</option>
                                            <option>Option 2</option>
                                            <option>Option 3</option>
                                            <option>Option 4</option>
                                            <option>Option 5</option>
                                        </select>
                                    </div>
    
                                    <div class="form-group">
                                            <label>الديانة</label>
                                            <select name ="" class="form-control">
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                                <option>Option 4</option>
                                                <option>Option 5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                                <label>الحالة الإجتماعية</label>
                                                <select name ="" class="form-control">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                    <option>Option 4</option>
                                                    <option>Option 5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                    <label>المؤهل العلمي</label>
                                                    <select name ="" class="form-control">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                        <option>Option 3</option>
                                                        <option>Option 4</option>
                                                        <option>Option 5</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                        <label> الإدارة</label>
                                                        <select name ="" class="form-control">
                                                            <option>Option 1</option>
                                                            <option>Option 2</option>
                                                            <option>Option 3</option>
                                                            <option>Option 4</option>
                                                            <option>Option 5</option>
                                                        </select>
                                                    </div>
                               
                              
                             
                              
                             
                              
                            </div>
                            
                        
                    </div>
                </div>
               
               
                <!-- END SAMPLE FORM PORTLET-->
            </div>

            <div class="col-md-12 ">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">بياتات جواز السفر والاقامة    </span>
                            </div>
                            
                        </div>
                        <div class="portlet-body form">
                            
                                <div class="form-body">
        
                                    <div class="form-group">
                                        <label>رقم جواز السفر </label>
                                        <div class="input-group input-icon-lg">
                                            <span class="input-group-addon">
                                                <i class="fa fa-keyboard-o"></i>
                                            </span>
                                            <input type="text" name ="user_passport" class="form-control input-lg" placeholder="رقم جواز السفر "> </div>
                                    </div>
        
                                    <div class="form-group">
                                            <label>تاريخه </label>
                                            <div class="input-group input-icon-lg">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" name ="user_passport_date" class="form-control input-lg" placeholder="تاريخه "> </div>
                                        </div>
        
                                        <div class="form-group">
                                                <label>نهاية </label>
                                                <div class="input-group input-icon-lg">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                    <input type="text" name ="user_passport_end_date" class="form-control input-lg" placeholder="نهاية "> </div>
                                            </div>
                
                                            <div class="form-group">
                                                    <label>رقم الاقامة / الهوية</label>
                                                    <div class="input-group input-icon-lg">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" name ="user_idno" class="form-control input-lg" placeholder="رقم الاقامة / الهوية"> </div>
                                                </div>
        
                                                <div class="form-group">
                                                        <label>مكان اصدار الاقامة</label>
                                                        <div class="input-group input-icon-lg">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-map"></i>
                                                            </span>
                                                            <input type="text" name ="user_idno_place" class="form-control input-lg" placeholder="مكان اصدار الاقامة"> </div>
                                                    </div>
                                                    <div class="form-group">
                                                            <label>تاريخ اصدار الاقامة / الهوية</label>
                                                            <div class="input-group input-icon-lg">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                                <input type="text" name="user_idno_date" class="form-control input-lg" placeholder="تاريخ اصدار الاقامة / الهوية"> </div>
                                                        </div>

                                                        <div class="form-group">
                                                                <label>تاريخ انتهاء الاقامة / الهوية</label>
                                                                <div class="input-group input-icon-lg">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                    <input type="text" name ="user_idno_end_date" class="form-control input-lg" placeholder="تاريخ انتهاء الاقامة / الهوية"> </div>
                                                            </div>
                               
                                  
                                 
                                
                                </div>
                          
                           
                        </div>
                    </div>
                   
                   
                    <!-- END SAMPLE FORM PORTLET-->
                </div>

                <div class="col-md-12 ">
                        <!-- BEGIN SAMPLE FORM PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-red-sunglo">
                                    <i class="icon-settings font-red-sunglo"></i>
                                    <span class="caption-subject bold uppercase"> بيانات حاله الوظيفي والتامينات </span>
                                </div>
                                
                            </div>
                            <div class="portlet-body form">
                                
                                    <div class="form-body">
            
                                            <div class="form-group">
                                                    <label>الجنسية</label>
                                                    <select name ="user_job_type" class="form-control">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                        <option>Option 3</option>
                                                        <option>Option 4</option>
                                                        <option>Option 5</option>
                                                    </select>
                                                </div>
                
            
                                        <div class="form-group">
                                                <label>الحاله الوظيفية </label>
                                                <div class="input-group input-icon-lg">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                    <input type="text" name ="user_job_insure" class="form-control input-lg" placeholder="التامينات "> </div>
                                            </div>
            
                                            <div class="form-group">
                                                    <label>رقم التاميني </label>
                                                    <div class="input-group input-icon-lg">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" name ="user_job_insure_id" class="form-control input-lg" placeholder="رقم التاميني "> </div>
                                                </div>
                    
                                                      
                                   
                                      
                                     
                                    
                                    </div>
                                    <div class="form-actions">
                                            <button type="submit" class="btn blue">حفظ</button>
                                            <button type="button" class="btn default">رجوع</button>
                                        </div>
                               
                            </div>
                        </div>
                       
                       
                        <!-- END SAMPLE FORM PORTLET-->
                    </div>
            </form>
    </div>

@endsection
