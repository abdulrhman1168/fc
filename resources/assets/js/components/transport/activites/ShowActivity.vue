<template>
<div>
    <div class="panel-heading">
        {{ trans('modules.request_details') }}
    </div>

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
                    <tbody> 
                    <tr>
                        <th>
                        {{ trans('modules.request_date') }}

                        </th>

                        <th>
                        {{ trans('modules.destination') }}
                        </th>

                        <th>
                        {{ trans('modules.location') }}
                        </th>

                        <th>
                        {{ trans('modules.transport_date') }}
                        </th>

                        <th>
                        {{ trans('modules.coordinators_count') }}
                        </th>

                    </tr>
                    <tr>
                        <td>{{activity.hijri_date}}</td> 
                        <td>{{activity.destination}}</td>                              
                        <td>{{activity.location}}</td>                              
                        <td>{{activity.transport_date}}</td>                              
                        <td>{{activity.coordinators_count}}</td>                              
                              
                        
                    </tr>

                    <tr>
                        <th>
                        {{ trans('modules.coordinator') }}

                        </th>

                        <th>
                        {{ trans('modules.coordinator_mobile') }}
                        </th>

                        <th>
                        {{ trans('modules.transport_going') }}
                        </th>

                        <th>
                        {{ trans('modules.transport_back') }}
                        </th>

                        <th>
                        {{ trans('modules.students_count') }}
                        </th>

                    </tr>
                    <tr>
                        <td>{{activity.coordinator}}</td> 
                        <td>{{activity.coordinator_mobile}}</td>                              
                        <td>{{activity.transport_going}}</td>                              
                        <td>{{activity.transport_back}}</td>                              
                        <td>{{activity.students_count}}</td>                              
                           
                        
                    </tr>


                </tbody>
                  </table>
            </div>
        </div>
    </div>


        <div class="panel-heading">
        {{ trans('modules.participate_students') }}
    </div>

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
                        <th>
                            {{ trans('modules.Participate_Transport') }}
                        </th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="student in students" v-bind:key="student.student_id">
                            <td>
                                {{student.student_id}}
                            </td>
                            <td>
                                {{student.student_name}}
                            </td>
                            <td>
                                {{student.faculty}}
                            </td>
                            <td v-if="student.participate_transport == '1'">{{trans('modules.yes')}}</td>
                            <td v-else>{{trans('modules.no')}}</td>

                        </tr>

                    </tbody>
                </table>
                <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchActivityStudents(pagination.prev_page_url)">{{trans('modules.prev')}}</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">{{trans('modules.page')}} {{ pagination.current_page }} {{trans('modules.of')}} {{ pagination.last_page }}</a></li>
            
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchActivityStudents(pagination.next_page_url)">{{trans('modules.next')}}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <br><br>

    <div v-if="activity.deandecision == null">
    <div class="panel-heading">
        {{ trans('modules.approvement') }}
    </div>
    <div class='panel-body'>
        <form @submit.prevent="storeApprovment" method="post" >     
                <div class="form-group">
                <label  class="col-sm-2 control-label">{{trans('modules.approve_request')}}</label>
                <div class="col-sm-10">
                <select class="form-control"  v-model="approvment.status">
                   <option value="1">{{trans('modules.yes')}}</option>
                   <option value="0">{{trans('modules.no')}}</option>

                </select>
                <span class="help-block" v-if="errors.status" >
                <strong class="text-danger" v-for="(value,index,key) in errors.status" v-bind:key="key">{{value}}</strong>
                </span>
                </div>
            </div>
            <br><br>
            <div class="form-group">
            <label  class="col-sm-2 control-label">{{trans('modules.driver')}}</label>
            <div class="col-sm-10">
            <select class="form-control"  v-model="approvment.driver_id">
                <option  v-for="(driver) in drivers " v-bind:key="driver.id" :value="driver.id">{{driver.name}}</option>
            </select>
            <span class="help-block" v-if="errors.driver_id" >
            <strong class="text-danger" v-for="(value,index,key) in errors.driver_id" v-bind:key="key">{{value}}</strong>
            </span>
            </div>

            <br> <br>
            <div class="form-group ">
                <div class="col-xs-12">
                <br> <input type="submit" value="حفظ" class="btn btn-primary btn-md">
                </div>
            </div>
        </div>

        <br>
        <br>




                </form>
        </div >
        </div>


</div>
</template>

<script>
export default {
    props: ['activity'],
    watch:{
        'approvment.status': function (val, oldVal)
        { 
            if(val == '1')
            {
              this.drivers = this.tempDrivers;

            }
            else
            {
                this.drivers = [];
            }
        }
    },
    created() {
        this.fetchActivityStudents();
        this.fetchDrivers();
    },
    data() {
        return {
            activity_id:this.activity.id,
            students:[],
            drivers:[],
            tempDrivers:[],
            approvment:{
                status:'',
                driver_id:'',
            },

            pagination:{},
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[]
        };
    },
  methods:{
    fetchActivityStudents(page_url) {
      let vm = this;
      page_url = page_url || `get_activity_students/${this.activity_id}`;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.students = res.data;
          vm.makePagination(res);

        })
        .catch(err => console.log(err));
    },
    fetchDrivers() {
      
      fetch('/transport/control/get_drivers?noPaginate=1')
        .then(res => res.json())
        .then(res => {
          this.tempDrivers = res;
        })
        .catch(err => console.log(err));
    },
    makePagination(meta) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: meta.next_page_url,
        prev_page_url: meta.prev_page_url
      };
      this.pagination = pagination;
    },
    storeApprovment()
    {
        fetch(`/transport/activities/${this.activity_id}/approvement`, {
          method: 'post',
          body: JSON.stringify(this.approvment),
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
              console.log(data);
              alert(data.message);
              this.clearForm();
            }

          })
          .catch(err => console.log(err)); 
          
        },
        clearForm()
        {
            this.approvment.status = '';
            this.approvment.driver_id = '';
        }

            
  }

}
</script>

<style>
.pagination
{
    float: left;
}
</style>
