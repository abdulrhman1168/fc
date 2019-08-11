<template>
<div>
<div class='panel-body'>
<form @submit.prevent="AddActivity" method="post" >  
        <div class="form-group ">
          <div class="col-xs-6"><label >اسم المنسقة مع الطالبات</label> 
            <input  v-model="activity.coordinator"  type="text" class="form-control">
            <span class="help-block" v-if="errors.coordinator" >
              <strong class="text-danger" v-for="(value,index,key) in errors.coordinator" v-bind:key="key">{{value}}</strong>
            </span>
          </div>
        </div>
      <div class="form-group ">
        <div class="col-xs-6">
          <label >رقم جوال المنسقة</label>
          <input  v-model="activity.coordinator_mobile"  type="text" class="form-control">
          <span class="help-block" v-if="errors.coordinator_mobile" >
            <strong class="text-danger" v-for="(value,index,key) in errors.coordinator_mobile" v-bind:key="key">{{value}}</strong>
          </span>
        </div>
      </div>
      
      <div class="form-group ">
        <div class="col-xs-6">
          <label >جهة الخدمة المطلوبه</label>
          <input  v-model="activity.service_organization"  type="text" class="form-control">
          <span class="help-block" v-if="errors.service_organization" >
            <strong class="text-danger" v-for="(value,index,key) in errors.service_organization" v-bind:key="key">{{value}}</strong>
          </span>
       </div>
      </div>
      <div class="form-group ">
        <div class="col-xs-6">
          <label >الجهة</label>
          <input  v-model="activity.destination"  type="text" class="form-control">
          <span class="help-block" v-if="errors.destination" >
            <strong class="text-danger" v-for="(value,index,key) in errors.destination" v-bind:key="key">{{value}}</strong>
          </span>
        </div>
      </div>
      <div class="form-group ">
        <div class="col-xs-6">
          <label >موقع الوجهة</label>
          <input  v-model="activity.location"  type="text" class="form-control">
          <span class="help-block" v-if="errors.location" >
            <strong class="text-danger" v-for="(value,index,key) in errors.location" v-bind:key="key">{{value}}</strong>
          </span>
        </div>
      </div>
      <div class="form-group ">
        <div class="col-xs-6">
          <label >تاريخ النقل</label>
          <input id="hijrdate" v-model="activity.transport_date" type="hidden" class="form-control">
          <input  type="text" class="form-control hijri-datepicker-input-vue">
          <span class="help-block" v-if="errors.transport_miladi_date" >
            <strong class="text-danger" v-for="(value,index,key) in errors.transport_miladi_date" v-bind:key="key">{{value}}</strong>
          </span>
        </div>
      </div>
      <div class="form-group ">
        <div class="col-xs-6">
          <label >وقت الذهاب</label>
          <input  v-model="activity.transport_going"  type="time" class="form-control">
          <span class="help-block" v-if="errors.transport_going" >
            <strong class="text-danger" v-for="(value,index,key) in errors.transport_going" v-bind:key="key">{{value}}</strong>
          </span>
        </div>
      </div>
      <div class="form-group ">
        <div class="col-xs-6">
          <label >وقت العودة</label>
          <input  v-model="activity.transport_back"  type="time" class="form-control">
          <span class="help-block" v-if="errors.transport_back" >
            <strong class="text-danger" v-for="(value,index,key) in errors.transport_back" v-bind:key="key">{{value}}</strong>
          </span>
        </div>
      </div>
      <div class="form-group ">
        <div class="col-xs-6">
          <label >عدد الطالبات المراد توفير وسيلة النقل لهن</label>
          <input  v-model="activity.students_count"  type="number" class="form-control">
          <span class="help-block" v-if="errors.students_count" >
            <strong class="text-danger" v-for="(value,index,key) in errors.students_count" v-bind:key="key">{{value}}</strong>
          </span>
        </div>
      </div>
      <div class="form-group ">
        <div class="col-xs-6">
          <label >عدد المرافقات من الكادر الاداري</label>
          <input  v-model="activity.coordinators_count"  type="number" class="form-control">
          <span class="help-block" v-if="errors.coordinators_count" >
            <strong class="text-danger" v-for="(value,index,key) in errors.coordinators_count" v-bind:key="key">{{value}}</strong>
          </span>
        </div>
      </div>
      <div class="form-group ">
        <div class="col-xs-12">
          <label >{{trans('modules.student')}}</label>
          <v-select
                    v-model="activity.students_ids"
                    :debounce="250"
                    :on-search="getOptions"
                    :options="options"
                    placeholder=""
                    multiple
                    :filter-by="myFilter"
                    label="student_name">
          </v-select>        
          <span class="help-block" v-if="errors.students_ids" >
            <strong class="text-danger" v-for="(value,index,key) in errors.students_ids" v-bind:key="key">{{value}}</strong>
          </span>
        </div>

      </div>
    <br> <br>
      <div class="form-group ">
        <div class="col-xs-12">
          <br> <input type="submit" value="حفظ" class="btn btn-primary btn-md">
        </div>
      </div>
</form>
</div >

<div class='panel-body'>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bubble font-hide hide"></i>
                    <span class="caption-subject font-hide bold uppercase"><a href=""></a></span>
                </div>
            </div>
            <div class="portlet-body" id="chats">

                <table class='table table-bordered' >
                    <thead>
                    <tr >
                        <th>
                            {{ trans('modules.student_id') }}

                        </th>
                        <th>
                            {{ trans('modules.student_name') }}
                        </th>
                        <th>
                            {{ trans('modules.college') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="student in activity.students_ids" v-bind:key="student.student_id">
                            <td>
                                {{student.student_id}}
                            </td>
                            <td>
                                {{student.student_name}}
                            </td>
                            <td>
                                {{student.faculty}}
                            </td>

                        </tr>

                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            activity:{
                coordinator: '',
                coordinator_mobile: '',
                service_organization: '',
                destination: '',
                location: '',
                transport_date: '',
                transport_going: '',
                transport_back: '',
                students_count: '',
                coordinators_count: '',
                deandecision: '',
                transportationguidance: '',
                students_ids:[],

            },
            activity_id:'',
            options:[],
            pagination:{},
            edit: false,
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[],
            myFilter: (option, label, search) => {
            let temp = search.toLowerCase();
            return option.student_name.toLowerCase().indexOf(temp) > -1 || 
            option.student_id.toLowerCase().indexOf(temp) > -1
    }
        };
    },
  methods:{

    getOptions(search, loading) {
      loading(true)
      fetch(`/transport/home/students/filters?q=${search}`)
      .then(res => res.json())
      .then(res => {
         this.options = res;
         loading(false)
      })
    },
    AddActivity()
    {
        this.errors = [];
        this.activity.transport_date = $('#hijrdate').val();
        fetch('/transport/activities', {
          method: 'post',
          body: JSON.stringify(this.activity),
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
              this.clearForm();
              alert('activity Added');
            }

          })
          .catch(err => console.log(err));
     },
     clearForm()
     {
       this.activity.transport_date = '';
       this.activity.transport_going = '';
       this.activity.transport_back = '';
       this.activity.students_count = '';
       this.activity.coordinator = '';
       this.activity.coordinator_mobile = '';
       this.activity.service_organization = '';
       this.activity.destination = '';
       this.activity.location = '';
       this.activity.coordinators_count = '';
       this.activity.students_ids = [],
       this.activity.coordinators_count = '';
       this.activity.coordinators_count = '';
       this.activity.coordinators_count = '';
      $('.hijri-datepicker-input').val("");

     },
   
  }

}
</script>

<style>
.pagination
{
    float: left;
}
</style>
