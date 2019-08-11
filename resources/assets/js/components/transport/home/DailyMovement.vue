<template>
<div class="panel panel-default">

        <div class="panel-heading">{{trans('modules.notes-on-drivers')}}</div>
        <form @submit.prevent="AddDailyMovementReport" class="form-horizontal" >
            <div class="form-group">
             <label class="control-label col-md-4">{{trans('modules.duration')}}</label>
                <div class="col-xs-7">
                    <select class="form-control" id="sel1" name="city" v-model="report.duration">
                        <option value="1">{{trans('modules.morning')}}</option>
                        <option value="2">{{trans('modules.evening')}}</option>
                    </select>
                <span class="help-block" v-if="errors.duration" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.duration" v-bind:key="key">{{value}}</strong>
                    </span>
                </div> 
            </div>  
            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-late')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-late" v-model="report.status.late" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" name="vehicle-late">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['late']"    type="text" >
                </div>            
            </div>


            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-absence')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-absence" v-model="report.status.absence" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" name="vehicle-absence">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['absence']"    type="text" >
                </div>            
            </div>     




            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-clean')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-clean" v-model="report.status.clean" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-clean">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['clean']"    type="text" >
                </div>            
            </div>     





            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-air-condition')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-air-condition" v-model="report.status.air_condition" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" name="vehicle-air-condition">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control  required"      v-model="report.notes['air_condition']"    type="text" >
                </div>            
            </div>     





            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-glass-broken')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-glass-broken" v-model="report.status.glass_broken" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-glass-broken">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['glass_broken']"    type="text" >
                </div>            
            </div>               




            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-fuel')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-fuel" v-model="report.status.fuel" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-fuel">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['fuel']"    type="text" >
                </div>            
            </div>     




            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.supervisior-absence')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"   name="supervisior-absence" v-model="report.status.supervisior_absence" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="supervisior-absence">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['supervisior_absence']"    type="text" >
                </div>            
            </div>     



            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-driver-replacement')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" name="driver-replacement" v-model="report.status.driver_replacement" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="driver-replacement">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['driver_replacement']"    type="text" >
                </div>            
            </div>     


            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-smoking')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" name="vehicle-smoking" v-model="report.status.smoking" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-smoking">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['smoking']"    type="text" >
                </div>            
            </div>  



            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-covers-light')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-covers-light" v-model="report.status.covers_light" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-covers-light">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['covers_light']"    type="text" >
                </div>            
            </div>  



            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.age-conidition')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="age-conidition" v-model="report.status.age_conidition" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="age-conidition">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['age_conidition']"    type="text" >
                </div>            
            </div>  


            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.tires-problem')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="tires-problem" v-model="report.status.tires_problem" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="tires-problem">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['tires_problem']"    type="text" >
                </div>            
            </div>  


            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.continous-problems')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="continous-problems" v-model="report.status.continous_problems" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="continous-problems">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['continous_problems']"    type="text" >
                </div>            
            </div>  

            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-not-permit-student')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-not-permit-student" v-model="report.status.not_permit_student" value="1"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio"  name="vehicle-not-permit-student">  لا </label>
                </div>
                <label class="control-label col-md-1" for="ara_time">{{trans('modules.notes')}}</label>
                <div class="col-md-4">
                    <input class="form-control required"   v-model="report.notes['not_permit_student']"    type="text" >
                </div>            
            </div>  

        <div class="panel-footer">
            <button  class="btn btn-success disabled" type="submit" style="pointer-events: all; cursor: pointer;"><i class="fa fa-check"></i> حفظ البيانات</button>
        </div>
        </form>
</div>
</template>

<script>
export default {
   data(){
        return {
            errors:[],
            report:{
            driver_id:this.$route.params.id,
            status:{
                late:'',
                absence:'',
                clean:'',
                air_condition:'',
                glass_broken:'',
                fuel:'',
                supervisior_absence:'',
                driver_replacement:'',
                smoking:'',
                covers_light:'',
                age_conidition:'',
                tires_problem:'',
                continous_problems:'',
                not_permit_student:'',
            },
            duration:'',
            date:this.$route.params.date,
            notes:{},
            },
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        }

    },
   methods:{
    AddDailyMovementReport()
    {
        fetch('/transport/home/daily_movement/store', {
          method: 'post',
          body: JSON.stringify(this.report),
          headers: {
            'content-type': 'application/json',
            'X-CSRF-TOKEN': this.token

          }
        })
          
        .then(res => res.json())
        .then(data => {
          if(data.errors)
          {
            this.errors = data.errors;
          }
          else
          {
              alert(data[0]);
          }

        })
        .catch(err => console.log(err));
    }

   }
   
}
</script>

<style>

</style>
           