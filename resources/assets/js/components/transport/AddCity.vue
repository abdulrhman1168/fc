<template>
<div>
<div class='panel-body'>
<form @submit.prevent="AddCity" method="post" >     
                <div class="form-group ">
                <div class="col-xs-5">

                    <label for="ex3">{{trans('modules.city_name_ar')}}</label>
                    <input  class="form-control" id="ex3" type="text" v-model="city.name_ar">
                    <span class="help-block" v-if="errors.name_ar" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.name_ar" v-bind:key="key">{{value}}</strong>
                    </span>
                    
                </div>
                </div>

                <div class="form-group ">
                <div class="col-xs-5">
                <label for="ex3">{{trans('modules.city_name_en')}}</label>
                <input name="name_en" class="form-control" id="ex3" type="text" v-model="city.name_en">
                <span class="help-block" v-if="errors.name_en" >
                <strong class="text-danger" v-for="(value,index,key) in errors.name_en" v-bind:key="key" v-text="value"></strong>
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
        {{ trans('modules.cities') }}
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
                            {{ trans('modules.city_name_ar') }}
                        </th>
                        <th>
                            {{ trans('modules.city_name_en') }}
                        </th>

                        <th>{{trans('modules.actions')}}</th>

                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="city in cities" v-bind:key="city.id">
                            <td>
                                {{city.id}}
                            </td>
                            <td>
                                {{city.name_ar}}
                            </td>
                            <td>
                                {{city.name_en}}
                            </td>
                            <td>
                                <button @click="editCity(city)" type="button"  class="btn green">{{ trans('modules.edit') }}</button>
                                <button @click="deleteCity(city.id)" type="button"  class="btn green edit-action">{{ trans('modules.remove') }}</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchCities(pagination.prev_page_url)">{{trans('modules.prev')}}</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">{{trans('modules.page')}} {{ pagination.current_page }} {{trans('modules.of')}} {{ pagination.last_page }}</a></li>
            
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchCities(pagination.next_page_url)">{{trans('modules.next')}}</a></li>
                </ul>
                
            </div>
        </div>
    </div>
</div>

</template>

<script>
export default {
    created() {
        this.fetchCities();
    },
    data() {
        return {
            cities:[],
            city:{
                name_ar: '',
                name_en: '',
            },
            city_id:'',
            pagination:{},
            edit: false,
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[]
        };
    },
  methods:{
    fetchCities(page_url) {
      let vm = this;
      page_url = page_url || 'get_cities';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.cities = res.data;
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
    AddCity() {
      if (this.edit === false) {
        // Add
        fetch('city', {
          method: 'post',
          body: JSON.stringify(this.city),
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
              alert('City Added');
              this.fetchCities();
            }

          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch(`city/${this.city.city_id}`, {
          method: 'put',
          body: JSON.stringify(this.city),
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
              alert('City Updated');
              this.fetchCities();
            }
          })
          .catch(err => console.log(err));
      }
    },
    editCity(city) {
      this.edit = true;
      this.city.id = city.id;
      this.city.city_id = city.id;
      this.city.name_ar = city.name_ar;
      this.city.name_en = city.name_en;

    },
    deleteCity(id) {
      if (confirm('Are You Sure?')) {
        fetch(`city/${id}`, {
          method: 'delete',
          headers: {
                'X-CSRF-TOKEN': this.token
          }
        })
          .then(res => res.json())
          .then(data => {
            alert('City Removed');
            this.fetchCities();
          })
          .catch(err => console.log(err));
      }
    },
    clearForm() {
      this.edit = false;
      this.city.id = null;
      this.city.city_id = null;
      this.city.name_ar = '';
      this.city.name_en = '';
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
