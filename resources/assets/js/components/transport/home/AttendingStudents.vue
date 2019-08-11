<template>
<div class="panel panel-default">

        <div class="panel-heading">{{trans('modules.attending-students')}}</div>
        <form @submit.prevent="AddAttendaceReport" class="form-horizontal">
            <table class="table">
                <tbody>
                <tr>
                    <th>م</th>
                    <th>اسم الطالبة</th>
                    <th>حاضرة</th>
                    <th>غائبة</th>
                </tr>
                <tr v-for="(student,key) in students" v-bind:key="key">
                <td>{{key + 1}}</td>
                <td>  {{student.student_name}} </td>
                    <td><input type="radio" v-model="form.absenceStudents[key]" class="required"></td>
                    <td><input type="radio" v-model="form.absenceStudents[key]"  v-bind:value="student.student_id"  class="required"></td>
                </tr>
                </tbody>
            </table>
            
            <div class="form-group">
                <label class="control-label col-md-2">توقيع السائق</label>
                <div class="col-md-2">
                    <label class="radio-inline"><input type="radio" v-model="form.driver_sign" value="1">تم</label>
                    <label class="radio-inline"><input type="radio" v-model="form.driver_sign" value="0">لم يتم</label>
                     <span class="help-block" v-if="errors.driver_sign" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.driver_sign" v-bind:key="key" v-text="value"></strong>
                    </span> 
                </div>
                <label class="control-label col-md-2" for="ara_time">وقت وصول الحافلة</label>
                <div class="col-md-4">
                    <input class="form-control time required" id="ara_time" v-model="form.time_arrival"  min="" type="time" required>
                    <span class="help-block" v-if="errors.time_arrival" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.time_arrival" v-bind:key="key" v-text="value"></strong>
                    </span> 
                </div>            
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">مصادقة المشرف</label>
                <div class="col-md-2">
                    <label class="radio-inline"><input type="radio" v-model="form.supervisor_sign" value="1">تم</label>
                    <label class="radio-inline"><input type="radio" v-model="form.supervisor_sign"  value="0">لم يتم</label>
                    <span class="help-block" v-if="errors.supervisor_sign" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.supervisor_sign" v-bind:key="key" v-text="value"></strong>
                    </span> 
                </div>
                <label class="control-label col-md-2" for="at_name">اسم المشرف</label>
                <div class="col-md-4">
                    <input class="form-control required" id="at_name" name="at_name" v-model="form.supervisor_name" min="" type="text" required="true">
                    <span class="help-block" v-if="errors.supervisor_name" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.supervisor_name" v-bind:key="key" v-text="value"></strong>
                    </span> 
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
            form:{
                absenceStudents:[],
                time_arrival:'',
                driver_sign:'',
                supervisor_sign:'',
                driver_id:this.$route.params.id,
                supervisor_name:'',
                date:this.$route.params.date,
                track_id:this.$route.params.track,
                
            },
            students:[],
            errors:[],
            id:this.$route.params.id,
            driver:'',
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        }

    },
    created()
    {
        this.getStudents();
    },
   methods:{
    getStudents()
    {
         fetch(`/transport/home/get_students_driver/${this.form.track_id}/${this.id}`)
        .then(res => res.json())
        .then(res => {
          this.students = res;
        })
        .catch(err => console.log(err));
    },
    AddAttendaceReport()
    {
        fetch('/transport/home/students_attendace/store', {
          method: 'post',
          body: JSON.stringify(this.form),
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
              alert(data.message);
              this.clearForm();
          }

        })
        .catch(err => console.log(err));
    },
    clearForm()
    {
        this.errors = [];
        this.form.absenceStudents = [];
        this.form.time_arrival='';
        this.form.driver_sign='';
        this.form.supervisor_sign='';
        this.form.supervisor_name='';
    }
   }
   
}
</script>

<style>

</style>
           