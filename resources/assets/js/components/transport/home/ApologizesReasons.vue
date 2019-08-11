<template>
<div class="panel panel-default">
                    <div class="panel-heading">
          {{trans('modules.reasons')}}
        </div>
        <table class="table">
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
                    <td>{{excuess_student.faculty_name}}</td>
                    <td> {{excuess_student.track_ar}}</td>
                    <td>{{date}}</td>
                    <td> {{excuess_student.status}}</td>
                </tr>
            </tbody>
        </table>
</div>
</template>

<script>
export default {
   data(){
        return {
            excuess:[],
            id:this.$route.params.id,
            date:this.$route.params.date,
            track:this.$route.params.track,
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }

    },
    created()
    {
        this.getExcuess();
    },
   methods:{
    getExcuess()
    {
         fetch(`/transport/home/get_excueses/${this.track}/${this.date}/${this.id}`)
        .then(res => res.json())
        .then(res => {
          this.excuess = res;
        })
        .catch(err => console.log(err));
    },

   }
   
}
</script>

<style>

</style>
           