<template>
<div class="panel panel-default">
                    <div class="panel-heading">
          {{trans('modules.messages')}}
        </div>
        <table class="table">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>المرسل اليه</th>
                    <th>المسار</th>
                    <th>التاريخ</th>
                    <th>نص الرسالة</th>
                    <th>الارسال</th>
                </tr>

                <tr v-for="message in messages" v-bind:key="message.id">
                    <td>{{message.id}}</td>
                    <td v-if="message.receiver_status == 1">{{trans('modules.driver')}}</td>
                    <td v-else-if="message.receiver_status == 2">{{trans('modules.students')}}</td>
                    <td v-else>{{trans('modules.driver-and-students')}}</td>

                    <td>
                     <p >{{ tracks.track_ar}}</p>
                    </td>
                    <td>{{date}}</td>
                    <td>{{message.content}}</td>
                    <td v-if="message.send_status == 1"> {{trans('modules.done')}}</td>
                    <td v-else> {{trans('modules.failed')}}</td>

                </tr>
            </tbody>
        </table>
        <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getmessages(pagination.prev_page_url)">{{trans('modules.prev')}}</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">{{trans('modules.page')}} {{ pagination.current_page }} {{trans('modules.of')}} {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getmessages(pagination.next_page_url)">{{trans('modules.next')}}</a></li>
        </ul>
</div>
</template>

<script>
export default {
   data(){
        return {
            messages:[],
            track:{},
            id:this.$route.params.id,
            date:this.$route.params.date,
            track_id:this.$route.params.track,
            pagination:{},

        }

    },
    created()
    {
        this.getmessages();
    },
   methods:{
    getmessages(page_url) {
      let vm = this;
      page_url = page_url || `/transport/home/get_messages/${this.track_id}/${this.date}/${this.id}`;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.messages = res['messages'].data;
          this.tracks= res['tracks'];
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
    }
   }
   
}
</script>

<style>

</style>
           