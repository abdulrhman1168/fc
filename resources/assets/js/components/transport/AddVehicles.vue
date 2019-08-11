<template>
<div>
<div class='panel-body'>
<form @submit.prevent="AddVehicle" method="post" >     
                <div class="form-group ">
                <div class="col-xs-4">

                    <label for="ex4">{{trans('modules.vehicle_number')}}</label>
                    <input  class="form-control" id="ex3" type="text" v-model="vehicle.vehicle_number" required>
                    <span class="help-block" v-if="errors.vehicle_number" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.vehicle_number" v-bind:key="key">{{value}}</strong>
                    </span>
                    
                </div>
                </div>

                <div class="form-group ">
                <div class="col-xs-4">
                <label for="ex4">{{trans('modules.plate_number')}}</label>
                <input  class="form-control" id="ex3" type="text" v-model="vehicle.plate_number" required>
                <span class="help-block" v-if="errors.plate_number" >
                <strong class="text-danger" v-for="(value,index,key) in errors.plate_number" v-bind:key="key" v-text="value"></strong>
                </span> 
                </div>
                </div>

                <div class="form-group ">
                <div class="col-xs-4">
                <label for="ex3">{{trans('modules.chair-number')}}</label>
                <input  class="form-control" id="ex3" type="number" v-model="vehicle.chair_number" required>
                <span class="help-block" v-if="errors.chair_number" >
                <strong class="text-danger" v-for="(value,index,key) in errors.chair_number" v-bind:key="key" v-text="value"></strong>
                </span> 
                </div>
                </div>

                <div class="form-group ">
                <div class="col-xs-1" style="margin-top:5px">
                    <label for="ex3"></label>
                    <button  class="btn green btn-block">{{trans('modules.save')}}</button>
                    
                </div>

                </div>
                <br>
                <br>
 



        </form>
</div >
    <br>

    <div class="panel-heading">
        {{ trans('modules.vehicles') }}
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
                            {{ trans('modules.serial') }}

                        </th>
                        <th>
                            {{ trans('modules.plate_number') }}
                        </th>
                        <th>
                            {{ trans('modules.vehicle_number') }}
                        </th>
                        <th>
                            {{ trans('modules.chair-number') }}
                        </th>

                        <th>{{trans('modules.actions')}}</th>

                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="vehicle in vehicles" v-bind:key="vehicle.id">
                            <td>
                                {{vehicle.id}}
                            </td>
                            <td>
                                {{vehicle.plate_number}}
                            </td>
                            <td>
                                {{vehicle.vehicle_number}}
                            </td>
                            <td>
                              {{vehicle.chair_number}}
                            </td>
                            <td>
                                <button @click="editVehicle(vehicle)" type="button"  class="btn green">{{ trans('modules.edit') }}</button>
                                <button @click="deleteVehicle(vehicle.id)" type="button"  class="btn green edit-action">{{ trans('modules.remove') }}</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchVehicles(pagination.prev_page_url)">{{trans('modules.prev')}}</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">{{trans('modules.page')}} {{ pagination.current_page }} {{trans('modules.of')}} {{ pagination.last_page }}</a></li>
            
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchVehicles(pagination.next_page_url)">{{trans('modules.next')}}</a></li>
                </ul>
                
            </div>
        </div>
    </div>
</div>

</template>

<script>
export default {
    created() {
        this.fetchVehicles();
    },
    data() {
        return {
            vehicles:[],
            vehicle:{
                vehicle_number: '',
                plate_number: '',
                chair_number:'',
            },
            vehicle_id:'',
            pagination:{},
            edit: false,
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[]
        };
    },
  methods:{
    fetchVehicles(page_url) {
      let vm = this;
      page_url = page_url || 'get_vehicles';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.vehicles = res.data;
          vm.makePagination(res);
          vm.clearForm();

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
      console.log(this.pagination);
    },
    AddVehicle() {
      if (this.edit === false) {
        // Add
        fetch('vehicle', {
          method: 'post',
          body: JSON.stringify(this.vehicle),
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
              console.log(this.errors)
            }
            else
            {
              this.clearForm();
              alert('vehicle Added');
              this.fetchVehicles();
            }

          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch(`vehicle/${this.vehicle.vehicle_id}`, {
          method: 'put',
          body: JSON.stringify(this.vehicle),
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
              console.log(this.errors)
            }
            else
            {
              this.clearForm();
              alert('vehicle Updated');
              this.fetchVehicles();
            }
          })
          .catch(err => console.log(err));
      }
    },
    editVehicle(vehicle) {
      this.edit = true;
      this.vehicle.id = vehicle.id;
      this.vehicle.vehicle_id = vehicle.id;
      this.vehicle.plate_number = vehicle.plate_number;
      this.vehicle.vehicle_number = vehicle.vehicle_number;
      this.vehicle.chair_number = vehicle.chair_number;


    },
    deleteVehicle(id) {
      if (confirm('Are You Sure?')) {
        fetch(`vehicle/${id}`, {
          method: 'delete',
          headers: {
                'X-CSRF-TOKEN': this.token
          }
        })
          .then(res => res.json())
          .then(data => {
            alert('vehicle Removed');
            this.fetchVehicles();
          })
          .catch(err => console.log(err));
      }
    },
    clearForm() {
      this.edit = false;
      this.vehicle.id = null;
      this.vehicle.vehicle_id = null;
      this.vehicle.plate_number = '';
      this.vehicle.vehicle_number = '';
      this.vehicle.chair_number = '';
      this.errors=[];

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
