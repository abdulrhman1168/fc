<template>
<div>
    <div class="panel-heading">
        {{ trans('modules.student_notes') }}
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
                      <tr>
                          <th>
                            {{trans('modules.request_date')}}
                          </th>
                          <th>
                            {{ trans('modules.student_id') }}
                          </th>

                          <th>
                            {{ trans('modules.student_name') }}
                          </th>

                          <th>
                            {{ trans('modules.track') }}
                          </th>

                          <th>
                            {{ trans('modules.note_content') }}
                          </th>

                          <th>
                            {{ trans('modules.note_reply') }}
                          </th>

                           <th>
                            {{ trans('modules.actions') }}
                          </th>   
                                
                          </tr>
                          </thead>

                          <tbody> 
                            <tr v-for="request in notes" v-bind:key="request.id">
                              <td>{{request.hijri_date}}</td>
                              <td>{{request.student_id}}</td> 
                              <td>{{request.student_name}}</td>                              
                              <td>{{request.track}}</td>                              
                              <td>{{request.content}}</td>
                              <td v-if="request.reply">{{request.reply}}</td>
                              <td v-else></td>
                              <td v-if="!request.reply">
                              <router-link  :to="`/vue/notes/${request.id}/reply`"><input  type="button" class="btn green"  :value="trans('modules.add_reply')" ></router-link>
                              </td>
                              <td v-else></td>                              
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
      <div id="result_body">
              <router-view :key="$route.fullPath"></router-view>
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
            notes:[],

            activity_id:'',
            pagination:{},
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[]
        };
    },
  methods:{
    fetchActivites(page_url) {
      let vm = this;
      page_url = page_url || 'get_notes';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.notes = res.data;
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
