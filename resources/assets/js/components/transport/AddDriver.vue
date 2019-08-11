<template>
<div>
<div class='panel-body'>
<form @submit.prevent="AddDriver" enctype="multipart/form-data">   
                
                <div class="form-group ">
                <div class="col-xs-4">
                    <label for="ex3">{{trans('modules.driver_name')}}</label>
                    <input  class="form-control" id="ex3" type="text" v-model="driver.name">
                    <span class="help-block" v-if="errors.name" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.name" v-bind:key="key" v-text="value"></strong>
                    </span> 
                </div>
                </div>

                <div class="form-group ">
                <div class="col-xs-4">

                    <label for="ex3">{{trans('modules.mobile')}}</label>
                    <input  class="form-control" id="ex3" type="text" v-model="driver.mobile">
                    <span class="help-block" v-if="errors.mobile" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.mobile" v-bind:key="key">{{value}}</strong>
                    </span>
                    
                </div>
                </div>

                <div class="form-group ">
                <div class="col-xs-4">
                    <label for="ex3">{{trans('modules.companion')}}</label>
                    <input  class="form-control" id="ex3" type="text" v-model="driver.companion">
                    <span class="help-block" v-if="errors.companion" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.companion" v-bind:key="key" v-text="value"></strong>
                    </span> 
                </div>
                </div>

                <div class="form-group ">
                <div class="col-xs-4">

                    <label for="ex3">{{trans('modules.companion_no')}}</label>
                    <input  class="form-control" id="ex3" type="text" v-model="driver.companion_no">
                    <span class="help-block" v-if="errors.companion_no" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.companion_no" v-bind:key="key">{{value}}</strong>
                    </span>
                    
                </div>
                </div>




               <div class="form-group ">
                <div class="col-xs-4">

                    <label for="ex3">{{trans('modules.vehicle')}}</label>
                    <select class="form-control" id="sel1"  v-model="driver.vehicle_id">
                        <option  v-for="(vehicle) in vehicles " :selected="driver.vehicle_id === vehicle.id" v-bind:value="vehicle.id">{{vehicle.vehicle_number + ' // ' + vehicle.plate_number}}</option>

                    </select>


                </div>
                </div>  
                
                <div class="form-group ">
                <div class="col-xs-4">
                    <label for="ex3">{{trans('modules.track')}}</label>
                    <v-select multiple taggable :options="tracks"  label="track_ar" v-model="driver.track" v-if="lang === 'ar'"></v-select>
                    <v-select multiple taggable :options="tracks" label="track_en" v-model="driver.track" v-else></v-select>
                </div>
                </div>  


                <div class="form-group ">
                <div class="col-xs-12">
                  <label for="ex3">{{trans('modules.attachment')}}</label>

                  <vue-upload-multiple-image
                    @upload-success="uploadImageSuccess"
                    @before-remove="beforeRemove"
                    @edit-image="editImage"
                    :data-images="driver.attachment"
                    idUpload="myIdUpload"
                    editUpload="myIdEdit"
                    browseText="رفع المرفقات"
                    dragText="لابد ان تكون المرفقات صور"
                    primaryText="صور"
                    popupText="يمكنك حذف الصورة او تعديلها او اضافة صورة اخري"
                    ></vue-upload-multiple-image>
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
        {{ trans('modules.drivers') }}
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
                            {{ trans('modules.driver_name') }}
                        </th>
                        <th>
                            {{ trans('modules.mobile') }}
                        </th>

                        <th>
                            {{ trans('modules.companion') }}
                        </th>
                        <th>
                            {{ trans('modules.companion_no') }}
                        </th>

                        <th>
                            {{ trans('modules.track') }}
                        </th>
                        <th>
                            {{ trans('modules.vehicle') }}
                        </th>

                        <th>{{trans('modules.attachment')}}</th>

                        <th>{{trans('modules.actions')}}</th>

                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(driver,key) in drivers" v-bind:key="key">
                            <td>
                                {{driver.id}}
                            </td>
                            <td>
                                {{driver.name}}
                            </td>
                            <td>
                                {{driver.mobile}}
                            </td>

                            <td>
                                {{driver.companion}}
                            </td>
                            <td>
                                {{driver.companion_no}}
                            </td>
                            <td v-if="lang == 'ar'">
                              <p v-for="(track,key) in driverTrack[driver.id]" v-bind:key="key">{{ track['track_ar']}}</p>
                                
                            </td>
                            <td v-else>
                              <p v-for="(track,key) in driverTrack[driver.id]" v-bind:key="key">{{ track['track_en']}}</p>    
                            </td>
                            <td>
                                {{driver.vehicle_number + ' // ' + driver.plate_number}}
                            </td>
                            <td>
                              <tr>
                                  <td v-for="(file,key) in driver.files" v-bind:key="file.id">
                                       <a :href="file.path"> مرفق{{key}} *** </a>
                                  </td>
                              </tr>
                            </td>

                            <td>
                                <button @click="editDriver(driver)" type="button"  class="btn green">{{ trans('modules.edit') }}</button>
                                <button @click="deleteDriver(driver.id)" type="button"  class="btn green edit-action">{{ trans('modules.remove') }}</button>
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
</div>

</template>

<script>
import VueUploadMultipleImage from 'vue-upload-multiple-image';

export default {
    props: {
        lang: String,
    },
    
    components: {
    VueUploadMultipleImage,
    },
    created() {
        this.fetchDrivers();
        this.fetchVehicles();
        this.fetchTracks();

    },
    data() {
        return {
            drivers:[],
            vehicles:[],
            tracks: [],
            driverTrack:[],

            driver:{
                name: '',
                mobile: '',
                companion:'',
                companion_no:'',
                track:'',
                vehicle_id:'',
                attachment:[],
            },
            formdata:new FormData(),
            driver_id:'',
            pagination:{},
            edit: false,
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[]
        };
    },
  methods:{
    uploadImageSuccess(formData, index, fileList) {
      //console.log(formData.getAll('file')[0]);
      this.formdata.append(`files[]`,formData.getAll('file')[0]);
      //console.log(this.formdata.getAll('files[]'));
    },
    beforeRemove (index, done, fileList) {
      console.log('index', index, fileList)
      var r = confirm("remove image")
      if (r == true) {
        done()
      } else {
      }
    },
    editImage (formData, index, fileList) {
      console.log('edit data', formData, index, fileList)
    },
    fetchDrivers(page_url) {
      let vm = this;
      page_url = page_url || 'get_drivers';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.drivers = res['drivers'].data;
          this.driverTrack = res['tracks'];
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
    AddDriver() {
      var self = this;
      if (this.edit === false) {
       axios.post('driver', this.driver)
         .then((response) => {
           this.uploadFiles(response.data[2]);
          alert('Driver Added');
            this.fetchVehicles();


          })
        .catch(function (error) {
          self.errors = error.response.data.errors;
          console.log(error);
        });
      } else {
        // Update
        axios.put(`driver/${this.driver.driver_id}`, this.driver)
         .then((response) => {
           console.log(response.data[0]);
           this.uploadFiles(response.data[0]);
           alert('Driver updated');

          })
        .catch(function (error) {
          self.errors = error.response.data.errors;
          console.log(error);
        })  
      }
    },
    uploadFiles(data)
    {
        var self = this;
        axios.post(`driver/upload_driver_files/${data}`, this.formdata)
        .then(function (response) {
              console.log(response);
              self.clearForm();
              self.fetchDrivers();
        })
        .catch(function (error) {
          alert('برجاء اعادة رفع الملحقات مرة اخري')
          console.log(error);
        });
    },
    editDriver(driver) {
      this.edit = true;
      this.driver.id = driver.id;
      this.driver.driver_id = driver.id;
      this.driver.mobile = driver.mobile;
      this.driver.name = driver.name;
      this.driver.companion = driver.companion;
      this.driver.companion_no = driver.companion_no;
      this.driver.track = driver.track;
      this.driver.vehicle_id = driver.vehicle_id;
      this.fetchVehicles('update');
    },
    deleteDriver(id) {
      if (confirm('Are You Sure?')) {
        fetch(`driver/${id}`, {
          method: 'delete',
          headers: {
                'X-CSRF-TOKEN': this.token
          }
        })
          .then(res => res.json())
          .then(data => {
            alert('Driver Removed');
            this.fetchDrivers();
            this.fetchVehicles();

          })
          .catch(err => console.log(err));
      }
    },
    
    clearForm() {
      this.edit = false;
      this.driver.id = null;
      this.driver.companion = null;
      this.driver.companion_no = null;
      this.driver.track = '';
      this.driver.vehicle_id = '';
      this.driver.mobile = '';
      this.driver.name = '';
      this.errors=[];
      

    },

    fetchTracks()
    {
        fetch('get_tracks?noPaginate=1')
        .then(res => res.json())
        .then(res => {
          this.tracks = res;

        })
        .catch(err => console.log(err));
    },
    fetchVehicles(action=null)
    {
        if(action == 'update')
        {
        fetch(`get_vehicles?noPaginate=1&id=${this.driver.vehicle_id}`)
                .then(res => res.json())
        .then(res => {
          this.vehicles = res;

        })
        .catch(err => console.log(err));
        
        }
        else
        {
          fetch('get_vehicles?noPaginate=1')
          .then(res => res.json())
          .then(res => {
            this.vehicles = res;

          })
          .catch(err => console.log(err));
        }

    },
    processFile(event) {
        let formData = new FormData();
        let files = event.target.files;
        for(let i = 0; i<files.length; i++)
        {
            formData.append(`files[${i}]`, files[i]);
        }
        this.driver.attachment =  formData;
    }
            
  }

}
</script>

<style>
.pagination
{
    float: left;
}
#my-strictly-unique-vue-upload-multiple-image {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.image-container[data-v-10e59822]
{
   width: 100%;
}
</style>
           