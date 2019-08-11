
<template>

    <div class="panel panel-default">
      
    <div class="panel-heading">
        {{ trans('modules.daily-movement') }}
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
                          <th> #</th>
                          <th>{{trans('modules.college')}}</th>
                          <th>{{trans('modules.duration')}}</th>
                          <th>{{trans('modules.date')}}</th>
                          <th>{{trans('modules.date-time')}}</th>
                          <th>{{trans('modules.status')}}</th>
                          <th>{{trans('modules.actions')}}</th>
                      </tr>

                      <tr v-for="report in dailymovments" v-bind:key="report.student_id">
                          <td>{{report.id}}</td>
                          <td>{{report.name}}</td>
                          <td v-if="report.duration == 1"> {{'صباحي'}}</td>
                          <td v-else> {{'مسائي'}}</td>
                          <td>{{report.hijri_date}}</td>
                          <td>{{report.created_at}}</td>
                          <td v-if="report.guidence == '0'"> {{'جديد'}}</td>
                          <td v-else> {{'تم التوجيه'}}</td>
                          <td>
                            <router-link :to="`/vue/daily_movment_show/${report.id}/${report.created_date}/${report.duration}`"><input type="button" class="btn yellow"  :value="trans('modules.show')" ></router-link>
                            <input v-if="report.guidence == '0'" @click="storeGuidence(report.id,report.created_date,report.duration)" type="button" class="btn green"  :value="trans('modules.guidance')" >
                          </td>
                      </tr>
                  </tbody>
                </table>
                <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchDailyMovment(pagination.prev_page_url)">{{trans('modules.prev')}}</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">{{trans('modules.page')}} {{ pagination.current_page }} {{trans('modules.of')}} {{ pagination.last_page }}</a></li>
            
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchDailyMovment(pagination.next_page_url)">{{trans('modules.next')}}</a></li>
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
      this.fetchDailyMovment();
    },
    data() {
        return {
            dailymovments:[],
            data:{
              id:'',
              date:'',
              duration:''
            },
            pagination:'',
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        };
    },
  methods:{
    fetchDailyMovment(page_url) {
      let vm = this;
      page_url = page_url || '/transport/get_allDailyMovment';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.dailymovments = res.data;
          vm.makePagination(res);
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

    storeGuidence(id,date,duration)
    {

        this.setData(id,date,duration)
        fetch('/transport/daily_movment/guidence/store', {
          method: 'post',
          body: JSON.stringify(this.data),
          headers: {
            'content-type': 'application/json',
            'X-CSRF-TOKEN': this.token

          }
        })          
        .then(res =>{
            if(res.status == 200)
            {
               alert('تم التوجيه بنجاح')
            }
          })
        .catch(err => console.log(err));
      
    },

    setData(id,date,duration)
    {
        this.data.id = id;
        this.data.date = date;
        this.data.duration = duration;

    }
  },

}
</script>

<style>
.pagination
{
    float: left;
}

</style>

