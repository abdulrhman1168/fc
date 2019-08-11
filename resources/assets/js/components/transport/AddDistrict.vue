<template>
<div>
<div class='panel-body'>
<form @submit.prevent="AddDistrict" method="post" >
                <div class="form-group ">
                <div class="col-xs-4">

                    <label for="ex3">{{trans('modules.city')}}</label>
                    <select class="form-control" id="sel1" name="city" v-model="district.city_id" v-if="lang === 'en'">
                        <option  v-for="(city) in cities "  v-bind:value="city.id">{{city.name_en}}</option>

                    </select>

                    <select class="form-control" id="sel1" name="city" v-model="district.city_id" v-else >
                        <option  v-for="(city) in cities "  v-bind:value="city.id">{{city.name_ar}}</option>

                    </select>

                </div>
                </div>     
                
                <div class="form-group ">
                <div class="col-xs-3">

                    <label for="ex3">{{trans('modules.district_name_ar')}}</label>
                    <input  class="form-control" id="ex3" type="text" v-model="district.name_ar">
                    <span class="help-block" v-if="errors.name_ar" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.name_ar" v-bind:key="key">{{value}}</strong>
                    </span>
                    
                </div>
                </div>

                <div class="form-group ">
                <div class="col-xs-3">
                <label for="ex3">{{trans('modules.district_name_en')}}</label>
                <input name="name_en" class="form-control" id="ex3" type="text" v-model="district.name_en">
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
        {{ trans('modules.districts') }}
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
                          {{ trans('modules.city') }}
                        </th>
                        <th>
                            {{ trans('modules.district_name_ar') }}
                        </th>
                        <th>
                            {{ trans('modules.district_name_en') }}
                        </th>

                        <th>{{trans('modules.actions')}}</th>

                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="district in districts" v-bind:key="district.id">
                            <td>
                                {{district.id}}
                            </td>
                            <td v-if="lang == 'en'">
                              {{district.city_name_en}}
                            </td>
                            <td v-else>
                              {{district.city_name_ar}}
                            </td>
                            <td>
                                {{district.name_ar}}
                            </td>
                            <td>
                                {{district.name_en}}
                            </td>
                            <td>
                                <button @click="editDistrict(district)" type="button"  class="btn green">{{ trans('modules.edit') }}</button>
                                <button @click="deleteDistrict(district.id)" type="button"  class="btn green edit-action">{{ trans('modules.remove') }}</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchDistricts(pagination.prev_page_url)">{{trans('modules.prev')}}</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">{{trans('modules.page')}} {{ pagination.current_page }} {{trans('modules.of')}} {{ pagination.last_page }}</a></li>
            
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchDistricts(pagination.next_page_url)">{{trans('modules.next')}}</a></li>
                </ul>
                
            </div>
        </div>
    </div>
</div>

</template>

<script>
export default {
    props: {
        lang: String,
    },
    created() {
        this.fetchDistricts();
        this.fetchCities();
    },
    data() {
        return {
            cities:[],
            districts:[],

            district:{
                name_ar: '',
                name_en: '',
                city_id:'',
            },
            district_id:'',
            pagination:{},
            edit: false,
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[]
        };
    },
  methods:{
    fetchDistricts(page_url) {
      let vm = this;
      page_url = page_url || 'get_districts';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          console.log(res);
          this.districts = res.data;
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
    },
    AddDistrict() {
      if (this.edit === false) {
        // Add
        fetch('district', {
          method: 'post',
          body: JSON.stringify(this.district),
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
              alert('District Added');
              this.fetchDistricts();
            }

          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch(`district/${this.district.district_id}`, {
          method: 'put',
          body: JSON.stringify(this.district),
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
              alert('District Updated');
              this.fetchDistricts();
            }
          })
          .catch(err => console.log(err));
      }
    },
    editDistrict(district) {
      this.edit = true;
      this.district.id = district.id;
      this.district.district_id = district.id;
      this.district.city_id = district.city_id;
      this.district.name_ar = district.name_ar;
      this.district.name_en = district.name_en;

    },
    deleteDistrict(id) {
      if (confirm('Are You Sure?')) {
        fetch(`district/${id}`, {
          method: 'delete',
          headers: {
                'X-CSRF-TOKEN': this.token
          }
        })
          .then(res => res.json())
          .then(data => {
            alert('District Removed');
            this.fetchDistricts();
          })
          .catch(err => console.log(err));
      }
    },
    
    clearForm() {
      this.edit = false;
      this.district.id = null;
      this.district.district_id = null;
      this.district.name_ar = '';
      this.district.name_en = '';
      this.errors=[];

    },

    fetchCities()
    {
        fetch('get_cities?noPaginate=1')
        .then(res => res.json())
        .then(res => {
          this.cities = res;

        })
        .catch(err => console.log(err));
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
           