<template>
<div class="panel panel-default">

        <div class="panel-heading">{{trans('modules.notes-on-drivers')}}</div>
        <form @submit.prevent="AddDailyMovementReport" class="form-horizontal" >
            
            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-late')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.late == '1'"  > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.late == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.late!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.late }}</label>
                </div>            
            </div>


            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-absence')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.absence == '1'" > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.absence == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.absence!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.absence }}</label>
                </div>            
            </div>     




            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-clean')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.clean == '1'"  > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.clean == null" >  لا </label>
                </div>
                <div class="col-md-5"  v-if="notes.clean!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.clean }}</label>
                </div>                 
            </div>     





            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-air-condition')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.air_condition == '1'" > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.air_condition == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.air_condition!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.air_condition }}</label>
                </div>             
            </div>     





            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-glass-broken')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.glass_broken == '1'"  > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.glass_broken == null">  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.glass_broken!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.glass_broken }}</label>
                </div>               
            </div>               




            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-fuel')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.fuel == '1'" > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.fuel == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.fuel!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.fuel }}</label>
                </div>                
            </div>     




            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.supervisior-absence')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled  :checked="status.supervisior_absence == '1'" > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.supervisior_absence == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.supervisior_absence!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.supervisior_absence }}</label>
                </div>                 
            </div>     



            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-driver-replacement')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.driver_replacement == '1'"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.driver_replacement == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.driver_replacement!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.driver_replacement }}</label>
                </div>            
            </div>     


            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-smoking')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.smoking == '1'" > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.smoking == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.smoking!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.smoking }}</label>
                </div>         
            </div>  



            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-covers-light')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.covers_light == '1'" > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.covers_light == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.covers_light!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.covers_light }}</label>
                </div>                  
            </div>  



            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.age-conidition')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.age_conidition == '1'"> نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.age_conidition == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.age_conidition!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.age_condition }}</label>
                </div>            
            </div>  


            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.tires-problem')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.tires_problem == '1'"  > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.tires_problem == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.tires_problem!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.tires_problem }}</label>
                </div>                  
            </div>  


            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.continous-problems')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.continous_problems == '1'"  > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.continous_problems == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.continous_problems!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.continous_problems }}</label>
                </div>              
            </div>  

            <div class="form-group">
                <label class="control-label col-md-4">{{trans('modules.vehicle-not-permit-student')}}</label>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.not_permit_student == '1'"  > نعم </label>
                </div>
                <div class="col-md-1">
                    <label class="radio-inline"> <input type="radio" disabled :checked="status.not_permit_student == null" >  لا </label>
                </div>
                <div class="col-md-5" v-if="notes.not_permit_student!=undefined">
                    <label class="control-label">{{trans('modules.notes') + ' : ' + notes.not_permit_student }}</label>
                </div>            
            </div>  

        </form>
</div>
</template>

<script>
export default {
   data(){
        return {
            driver_id:this.$route.params.id,
            date:this.$route.params.date,

            dailyMovementReport:{},
            notes:[],
            status:[],
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        }

    },
    created()
    {
        this.getDailyMovementReport();
    },
   methods:{
   getDailyMovementReport()
    {
         fetch(`/transport/home/get_daily_movement_report/2/${this.date}/${this.driver_id}`) // 2 = evening
        .then(res => res.json())
        .then(res => {

          this.status = res.dailyMovementReport.status;
          this.notes = res.dailyMovementReport.notes;
          this.dailyMovementReport= res.dailyMovementReport;
        })
        .catch(err => console.log(err));
    },
   }
   
}
</script>

<style>

</style>
           