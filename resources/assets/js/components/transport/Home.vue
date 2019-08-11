
<template>

    <div class="panel panel-default">
      
        <div class="panel-heading">
          {{trans('modules.home')}}
        </div>

  

        <div class='panel-body'>
            <div class="portlet light bordered">

              <div class="actions">

                    <!-- start filters !-->
                  <div class="form-group ">
                  <div class="col-xs-4 edit-form-group">

                      <label for="ex3">{{trans('modules.city')}}</label>
                      <select class="form-control"  v-model="filter.city" v-if="lang=='ar'">
                          <option  v-for="(city) in cities "  v-bind:value="city.id">{{city.name_ar}}</option>

                      </select>

                      <select class="form-control"  v-model="filter.city" v-else>
                          <option  v-for="(city) in cities "  v-bind:value="city.id">{{city.name_en}}</option>

                      </select>

                  </div>
                  </div>  

                  <div class="form-group ">
                  <div class="col-xs-4 edit-form-group">

                      <label for="ex3">{{trans('modules.driver')}}</label>
                      <select class="form-control"  v-model="filter.driver">
                          <option  v-for="(driver) in drivers "  v-bind:value="driver.id">{{driver.name}}</option>
                      </select>
                  </div>
                  </div> 
                
                  <div class="form-group ">
                  <div class="col-xs-4 edit-form-group">

                      <label for="ex3">{{trans('modules.district')}}</label>
                      <select class="form-control"  v-model="filter.district" v-if="lang=='ar'">
                          <option  v-for="(district) in districts "  v-bind:value="district.id">{{district.name_ar}}</option>

                      </select>

                      <select class="form-control"  v-model="filter.district" v-else>
                          <option  v-for="(district) in districts "  v-bind:value="district.id">{{district.name_en}}</option>
                      </select>
                  </div>
                  </div> 

                  <div class="form-group ">
                  <div class="col-xs-6 edit-form-group">

                      <label for="ex3">{{trans('modules.student')}}</label>
                      <v-select
                                v-model="filter.student"
                                :debounce="250"
                                :on-search="getOptions"
                                :options="options"
                                placeholder=""
                                reduce="student_id"
                                label="student_name">
                      </v-select>
                  </div>
                  </div> 
                  

                  <div class="form-group ">
                  <div class="col-xs-6 edit-form-group">

                      <label for="ex3">{{trans('modules.date')}}</label>
                      <input type="text" id="hijdate" class="form-control hijri-datepicker-input" v-model="filter.date">

                  </div>
                  </div>

                  
                  <div class="form-group ">
                  <div class="col-xs-6 edit-form-group">

                      <label for="ex3">{{trans('modules.college')}}</label>
                      <select class="form-control"  v-model="filter.college">
                          <option  v-for="(college) in colleges "  v-bind:value="college.id">{{college.name}}</option>

                      </select>

                  </div>
                  </div>


                  <div class="form-group ">
                  <div class="col-xs-6 edit-form-group">

                      <label for="ex3">{{trans('modules.track')}}</label>
                      <select class="form-control"  v-model="filter.track">
                          <option  v-for="(track) in tracks "  v-bind:value="track.track_id">{{track.track_ar}}</option>

                      </select>
                  </div>
                  </div> 
                  
                <div class="form-group ">
                  <div class="col-xs-1 edit-form-group">

                    <button @click="searchFilter"  class="btn green btn-block">{{trans('modules.search')}}</button>
                  </div>
                  </div>
               </div>
              
              <div class="portlet-body" id="chats">
           <br>
           <br>
           <br>
                  <table class='table table-bordered' >
                    <thead>
                      <tr>
                          <th>
                              {{trans('modules.serial')}}
                          </th>

                          <th>
                            {{trans('modules.driver')}}
                          </th>
                          <th>
                            {{trans('modules.driver_mobile')}}
                          </th>
                          <th>
                            {{trans('modules.vehicle')}}
                          </th>
                          <th>
                            {{trans('modules.track')}}
                          </th>
                          <th>
                              {{trans('modules.actions')}}
                          </th>
                          <th>
                              {{trans('modules.daily-movement')}}
                          </th>

                          </tr>
                          </thead>

                          <tbody>
                              <tr v-for="driver in drivers_paginate" v-bind:key="driver.id">
                              <td>{{driver.id}}</td>
                              <td> {{driver.name}} </td>
                              <td>{{driver.mobile}}</td>
                              <td>{{driver.plate_number + ' *** ' + driver.vehicle_number }}</td>
                              <td v-if="lang == 'ar'">
                                <p v-for="(track,key) in driverTrack[driver.id]" v-bind:key="key">{{ track['track_ar']}}</p>
                                  <br>
                              </td>
                              <td v-else>
                                <p v-for="(track,key) in driverTrack[driver.id]" v-bind:key="key">{{ track['track_en']}}</p>    
                              </td>                      
                               <td>
                                  <div v-for="(track,key) in driverTrack[driver.id]" v-bind:key="key">
                                <router-link  v-on:click.native="doSomethingCool" :to="`/vue/print_byan/${driverTrack[driver.id][key].track_id}/${date}/${driver.id}`"><input  type="button" class="btn green"  :value="trans('modules.print-bayan')" ></router-link>
                                <router-link  v-if="attendaceExist[driver.id] == 1" v-on:click.native="doSomethingCool" :to="`/vue/attendace_report/${driverTrack[driver.id][key].track_id}/${date}/${driver.id}`"><input type="button" class="btn green"  :value="trans('modules.attendance-report')" ></router-link>
                                <router-link  v-else v-on:click.native="doSomethingCool" :to="`/vue/attend_students/${driverTrack[driver.id][key].track_id}/${date}/${driver.id}`"><input  type="button" class="btn green"  :value="trans('modules.attending-students')" ></router-link>
                                <router-link  v-on:click.native="doSomethingCool" :to="`/vue/send_text_messages/${driverTrack[driver.id][key].track_id}/${driver.id}`"><input type="button" class="btn green"  :value="trans('modules.send-text-messages')" ></router-link>
                                <router-link  v-on:click.native="doSomethingCool" :to="`/vue/reasons/${driverTrack[driver.id][key].track_id}/${date}/${driver.id}`"><input type="button" class="btn green"  :value="trans('modules.Excuses')" ></router-link>
                                <router-link  v-on:click.native="doSomethingCool" :to="`/vue/messages/show/${driverTrack[driver.id][key].track_id}/${date}/${driver.id}`"><input type="button" class="btn green"  :value="trans('modules.messages')" ></router-link>
                                <br><br>
                                  </div>
                              </td>
                              <td>
                                <router-link  v-if="DailyMovement_m_exist[driver.id] != null" v-on:click.native="doSomethingCool" :to="`/vue/daily_movement_morning_report/${date}/${driver.id}`"><input type="button" class="btn green"  :value="trans('modules.daily-morning-movement')" ></router-link>
                                <router-link v-else v-on:click.native="doSomethingCool" :to="`/vue/daily_movement/${date}/${driver.id}`"><input type="button" class="btn green"  :value="trans('modules.add-daily-morning-movement')" ></router-link>
                                <router-link  v-if="DailyMovement_e_exist[driver.id] != null" v-on:click.native="doSomethingCool" :to="`/vue/daily_movement_evening_report/${date}/${driver.id}`"><input type="button" class="btn green"  :value="trans('modules.daily-evening-movement')" ></router-link>
                                <router-link v-else v-on:click.native="doSomethingCool" :to="`/vue/daily_movement/${date}/${driver.id}`"><input type="button" class="btn green"  :value="trans('modules.add-daily-evening-movement')" ></router-link>
                              </td>
                              </tr>
                          </tbody>
                  </table>
                <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchDrivers(pagination.prev_page_url)">{{trans('modules.prev')}}</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">{{trans('modules.page')}} {{ pagination.current_page }} {{trans('modules.of')}} {{ pagination.last_page }}</a></li>
            
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchDrivers(pagination.next_page_url)">{{trans('modules.next')}}</a></li>
                </ul>
              </div>
          </div>
        </div>
      <div id="result_body">
              <router-view :key="$route.fullPath"></router-view>
      </div>
    </div>


</template>

<script>
export default {
    props: {
        lang: String,
    },
    created() {
        this.fetchData('city','/transport/control/get_cities?noPaginate=1');
        this.fetchData('district','/transport/control/get_districts?noPaginate=1');
        this.fetchData('college','/transport/control/get_colleges?noPaginate=1');
        this.fetchData('driver','/transport/control/get_drivers?noPaginate=1');
        this.fetchDrivers();
        this.fetchData('track','/transport/control/get_tracks?noPaginate=1');

    },
    data() {
        return {
            cities:[],
            colleges:[],
            drivers:[],
            drivers_paginate:[],
            districts:[],
            tracks:[],
            options:[],
            filter:{
                city: '',
                college: '',
                driver:'',
                district:'',
                student:'',
                track:'',
                date:'',
            },
            driverTrack:[],
            attendaceExist:[],
            DailyMovement_m_exist:[],
            DailyMovement_e_exist:[],

            vehicle_id:'',
            pagination:{},
            edit: false,
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[]
        };
    },
  methods:{
    getOptions(search, loading) {
      loading(true)
      fetch(`home/students/filters?q=${search}`)
      .then(res => res.json())
      .then(res => {
         this.options = res;
         loading(false)
      })
    },
    fetchData(type,url) {
      let vm = this;
      fetch(url)
        .then(res => res.json())
        .then(res => {
          switch(type) {

          case 'city':
            this.cities = res;
            break;

          case 'college':
            this.colleges = res;
            break;
          case 'driver':
            this.drivers = res;
            break;
          case 'district':
            this.districts = res;
            break;
          case 'track':
            this.tracks = res;
            break;
        }
          vm.makePagination(res);
          //vm.clearForm();

        })
        .catch(err => console.log(err));
    },
    fetchDrivers(page_url) {
      let vm = this;
      page_url = page_url || '/transport/control/get_drivers';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.drivers_paginate = res['drivers'].data;
          this.driverTrack = res['tracks'];
          this.attendaceExist = res['attendace_exist'];
          this.DailyMovement_m_exist = res['DailyMovement_m_exist'];
          this.DailyMovement_e_exist = res['DailyMovement_e_exist'];

          this.date = res['date'];

          vm.makePagination(res);
          //vm.clearForm();
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
    searchFilter()
    {
        this.filter.date = $('#hijdate').val();
        fetch('/transport/home/filters', {
          method: 'post',
          body: JSON.stringify(this.filter),
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
            this.drivers_paginate = data.drivers.data;
            this.driverTrack = data.tracks[0];
            this.attendaceExist = data.tracks[1];
            this.DailyMovement_m_exist = data.tracks[2];
            this.DailyMovement_e_exist = data.tracks[3];
            this.date = data.date;

          }

        })
        .catch(err => console.log(err));
    },
    doSomethingCool()
    {  
      window.scrollTo(0,100);  
   }
    
  },

}
</script>

<style>
.pagination
{
    float: left;
}
.edit-form-group
{
  margin-top:15px;
}
</style>

