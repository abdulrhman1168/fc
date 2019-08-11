
<template>

    <div class="panel panel-default">
      
    <div class="panel-heading">
        {{ trans('modules.Excuses') }}
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
                          <th>اسم الطالبة</th>
                          <th>الكلية</th>
                          <th>المسار</th>
                          <th>التاريخ</th>
                          <th>الحالة</th>
                      </tr>

                      <tr v-for="excuess_student in excuess" v-bind:key="excuess_student.student_id">
                          <td>{{excuess_student.student_name}}</td>
                          <td>{{excuess_student.faculty}}</td>
                          <td> {{excuess_student.track_ar}}</td>
                          <td>{{excuess_student.hijridate}}</td>
                          <td> {{excuess_student.status}}</td>
                      </tr>
                  </tbody>
                </table>
                <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchExcuesses(pagination.prev_page_url)">{{trans('modules.prev')}}</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">{{trans('modules.page')}} {{ pagination.current_page }} {{trans('modules.of')}} {{ pagination.last_page }}</a></li>
            
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchExcuesses(pagination.next_page_url)">{{trans('modules.next')}}</a></li>
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
      this.fetchExcuesses();
    },
    data() {
        return {
            excuess:[],
            pagination:'',
        };
    },
  methods:{
    fetchExcuesses(page_url) {
      let vm = this;
      page_url = page_url || '/transport/get_excueses';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.excuess = res;
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
  },

}
</script>

<style>
.pagination
{
    float: left;
}

</style>

