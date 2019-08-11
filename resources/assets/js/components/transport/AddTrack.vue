<template>
<div>
<div class='panel-body'>
<form @submit.prevent="AddTrack" method="post" >

                <div class="form-group ">
                <div class="col-xs-3">

                    <label for="ex3">{{trans('modules.track_number')}}</label>
                    <input  class="form-control" id="ex3" type="text" v-model="track.track_number">
                    <span class="help-block" v-if="errors.track_number" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.track_number" v-bind:key="key">{{value}}</strong>
                    </span>

                </div>
                </div> 


                <div class="form-group ">
                <div class="col-xs-3">

                    <label for="ex3">{{trans('modules.city')}}</label>
                    <select @change="fetchDistricts($event)" class="form-control"   v-model="track.city_id" v-if="lang === 'en'">
                        <option  v-for="(city) in cities " :selected="track.city_id === city.id"  v-bind:value="city.id">{{city.name_en}}</option>

                    </select>

                    <select @change="fetchDistricts($event)" class="form-control"  v-model="track.city_id" v-else >
                        <option  v-for="(city) in cities "  v-bind:value="city.id" :selected="track.city_id === city.id">{{city.name_ar}}</option>

                    </select>
                  <span class="help-block" v-if="errors.city_id" >
                  <strong class="text-danger" v-for="(value,index,key) in errors.city_id" v-bind:key="key" v-text="value"></strong>
                  </span> 
                </div>
                </div>     
                
                <div class="form-group ">
                <div class="col-xs-3">

                    <label for="ex3">{{trans('modules.district')}}</label>
                    <select class="form-control"  v-model="track.district_id" v-if="lang === 'en'">
                        <option  v-for="(district) in districts "  v-bind:value="district.id" :selected="track.district_id === district.id">{{district.name_en}}</option>

                    </select>

                    <select class="form-control"  v-model="track.district_id" v-else >
                        <option  v-for="(district) in districts "  v-bind:value="district.id" :selected="track.district_id === district.id">{{district.name_ar}}</option>

                    </select>
                  <span class="help-block" v-if="errors.district_id" >
                  <strong class="text-danger" v-for="(value,index,key) in errors.district_id" v-bind:key="key" v-text="value"></strong>
                  </span> 
                </div>
                </div> 

                <div class="form-group ">
                <div class="col-xs-3">

                    <label for="ex3">{{trans('modules.college')}}</label>
                    <select class="form-control"  v-model="track.college_id">
                        <option  v-for="(college) in colleges "  v-bind:value="college.id">{{college.name}}</option>

                    </select>
                    <span class="help-block" v-if="errors.college_id" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.college_id" v-bind:key="key" v-text="value"></strong>
                    </span> 
                </div>
                </div> 
                <div class="form-group ">
                <div class="col-xs-1" style="margin-top:20px">
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
                            {{ trans('modules.track_number') }}

                        </th>
                        <th>
                            {{ trans('modules.city') }}
                        </th>
                        <th>
                            {{ trans('modules.district') }}
                        </th>
                        <th>
                            {{ trans('modules.college') }}
                        </th>

                        <th>{{trans('modules.actions')}}</th>

                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="track in tracks" v-bind:key="track.id">
                            <td>
                                {{track.track_number}}
                            </td>
                            <td v-if="lang === 'ar'">
                                {{track.city_name_ar}}
                            </td>
                            <td v-else>
                                {{track.city_name_en}}
                            </td>
                            <td v-if="lang === 'ar'">
                                {{track.district_name_ar}}
                            </td>
                            <td v-else>
                                {{track.district_name_en}}
                            </td>

                            <td>
                                {{track.college_name}}
                            </td>
                            <td>
                                <button @click="editTrack(track)" type="button"  class="btn green">{{ trans('modules.edit') }}</button>
                                <button @click="deleteTrack(track.track_id)" type="button"  class="btn green edit-action">{{ trans('modules.remove') }}</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchTracks(pagination.prev_page_url)">{{trans('modules.prev')}}</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">{{trans('modules.page')}} {{ pagination.current_page }} {{trans('modules.of')}} {{ pagination.last_page }}</a></li>
            
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchTracks(pagination.next_page_url)">{{trans('modules.next')}}</a></li>
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
        this.fetchCities()
        this.fetchTracks();
        this.fetchColleges();

    },
    data() {
        return {
            cities:[],
            districts:[],
            colleges:[],
            tracks:[],

            track:{
                track_number:'',
                city_id: '',
                district_id: '',
                college_id:'',
            },
            track_id:'',
            pagination:{},
            edit: false,
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[]
        };
    },
  methods:{
    fetchTracks(page_url) {
      let vm = this;
      page_url = page_url || 'get_tracks';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.tracks = res.data;
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
    AddTrack() {
      if (this.edit === false) {
        // Add
        fetch('track', {
          method: 'post',
          body: JSON.stringify(this.track),
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
              console.log('error')
            }
            else
            {
              console.log('success')
              this.clearForm();
              alert('Track Added');
              this.fetchTracks();
            }

          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch(`track/${this.track.track_id}`, {
          method: 'put',
          body: JSON.stringify(this.track),
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
              alert('Track Updated');
              this.fetchTracks();
            }
          })
          .catch(err => console.log(err));
      }
    },
    editTrack(track) {
      this.fetchAllDistricts();
      this.edit = true;
      this.track.track_number = track.track_number;
      this.track.id = track.track_id;
      this.track.track_id = track.track_id;
      this.track.city_id = track.city_id;
      this.track.district_id = track.district_id;
      this.track.college_id = track.college_id;

    },
    deleteTrack(id) {
      console.log(id);
      if (confirm('Are You Sure?')) {
        fetch(`track/${id}`, {
          method: 'delete',
          headers: {
                'X-CSRF-TOKEN': this.token
          }
        })
          .then(res => res.json())
          .then(data => {
            alert('Track Removed');
            this.fetchTracks();
          })
          .catch(err => console.log(err));
      }
    },
    
    clearForm() {
      this.edit = false;
      this.track.id = null;
      this.track.track_id = null;
      this.track.city_id = '';
      this.track.district_id = '';
      this.track.college_id = '';
      this.errors=[];
      this.track.track_number = '';

    },

    fetchCities()
    {
        fetch('get_cities?noPaginate=1')
        .then(res => res.json())
        .then(res => {
          this.cities = res;

        })
        .catch(err => console.log(err));
    },

    fetchDistricts(event)
    {
        
        fetch(`get_districts?noPaginate=1&city_id=${event.target.value}`)
        .then(res => res.json())
        .then(res => {
          this.districts = res;

        })
        .catch(err => console.log(err));
    },
     fetchAllDistricts()
    {
        
        fetch(`get_districts?noPaginate=1`)
        .then(res => res.json())
        .then(res => {
          this.districts = res;

        })
        .catch(err => console.log(err));
    },
    fetchColleges()
    {
         fetch('get_colleges?noPaginate=1')
        .then(res => res.json())
        .then(res => {
          this.colleges = res;

        })
        .catch(err => console.log(err));
    },
    onChange(event)
    {

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
           