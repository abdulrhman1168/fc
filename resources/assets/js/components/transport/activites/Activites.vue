<template>
<div>
    <div class="panel-heading">
        {{ trans('modules.activities') }}
    </div>

<div class='panel-body'>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bubble font-hide hide"></i>
                    <span class="caption-subject font-hide bold uppercase"><a href=""></a></span>
                </div>
            <div class="actions">
              <div class="portlet-input input-inline">
                <div class="input-icon right">
                  <a href="activities/create">
                  <input type="button" :value="trans('modules.add_activity')" class="btn green">
                  </a>
                </div>
              </div>
            </div>
            </div>
            <div class="portlet-body" id="chats">


                <table class='table table-bordered' >
                    <thead>
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
                              {{trans('modules.status')}}
                          </th>

                          <th>
                            {{ trans('modules.actions') }}
                          </th>

                          </tr>
                          </thead>

                          <tbody> 
                            <tr v-for="request in activities" v-bind:key="request.id">
                              <td>{{request.hijri_date}}</td> 
                              <td>{{request.destination}}</td>                              
                              <td>{{request.location}}</td>                              
                              <td>{{request.transport_date}}</td> 
                              <td v-if="request.deandecision == '1'">
                                  {{trans('modules.approved')}}
                              </td>   
                              <td v-else-if="request.deandecision == '0'">
                                  {{trans('modules.non_approved')}}
                              </td>    
                              <td v-else>
                                  {{trans('modules.New')}}
                              </td>                        
                              <td>
                              <a :href="'/transport/activities/'+request.id" class="btn green">{{ trans('modules.show') }}</a>  
                              </td>                              
                             
                            </tr>

                        </tbody>
                  </table>
                <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchActivites(pagination.prev_page_url)">{{trans('modules.prev')}}</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">{{trans('modules.page')}} {{ pagination.current_page }} {{trans('modules.of')}} {{ pagination.last_page }}</a></li>
            
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchActivites(pagination.next_page_url)">{{trans('modules.next')}}</a></li>
                </ul>
                
            </div>
        </div>
    </div>

</div>
</template>

<script>
export default {
    created() {
        this.fetchActivites();
    },
    data() {
        return {
            activities:[],

            activity_id:'',
            pagination:{},
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[]
        };
    },
  methods:{
    fetchActivites(page_url) {
      let vm = this;
      page_url = page_url || 'get_activties';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.activities = res.data;
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
      console.log(this.pagination);
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
