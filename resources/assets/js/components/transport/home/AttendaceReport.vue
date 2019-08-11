<template>
<div class="panel panel-default">
                    <div class="panel-heading">
          {{trans('modules.attendance-report')}}
        </div>
    <table class="table"> 
        <tbody>
            <tr>
                <th>اسم السائق</th>
                <td>{{driver.name}}</td> 
                <th>التاريخ</th>
                <td>{{date}}</td> 
            </tr>
    </tbody></table>
    <br>
    <table class="table">
        <tbody>
            <tr>
                <th>م</th>
                <th>اسم الطالبة</th>
                <th>حاضرة</th>
                <th>غائبة</th>
            </tr>
            <tr v-for="(student,key) in students" v-bind:key="key">
                <td>{{key + 1}}</td>
                <td>  {{student.student_name}} </td>
                    <td><input disabled :checked="student.absence == null" type="radio"></td>
                    <td><input disabled :checked="student.absence == '1'" type="radio"></td>
            </tr>
        </tbody>
    </table>
    <table class="table">
        <tbody>
            <tr>
                <th>عدد الحاضرات</th>
                <td>{{attendace_report.count_students_exist - attendace_report.count_students_absence}}</td>
                <th>عدد المتغيبات</th>
                <td>{{attendace_report.count_students_absence}}</td>
            </tr>
            <tr>
                <th>توقيع السائق</th>
                <td>
                    <label class="radio-inline"><input type="radio"  disabled :checked="attendace_report.driver_sign == '1'">تم</label>
                    <label class="radio-inline"><input type="radio"  disabled :checked="attendace_report.driver_sign == '0'">لم يتم</label>
                </td>
                <th>وقت وصول الحافلة</th>
                <td>{{attendace_report.time_arrival}}</td>
            </tr>
            <tr>
                <th>مصادقة المشرف</th>
                <td>
                    <label class="radio-inline"><input type="radio" disabled :checked="attendace_report.supervisor_sign == '1'">تمت</label>
                    <label class="radio-inline"><input type="radio" disabled :checked="attendace_report.supervisor_sign == '0'">لم تتم</label>
                </td>
                <th>اسم المشرف</th>
                <td>{{attendace_report.supervisor_name}}</td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
export default {
   data(){
        return {
            report_date:[],
            students:[],
            errors:[],
            id:this.$route.params.id,
            date:this.$route.params.date,
            track:this.$route.params.track,
            driver:'',
            attendace_report:'',
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        }

    },
    created()
    {
        this.getStudents();
    },
   methods:{
    getStudents()
    {
         fetch(`/transport/home/get_attendace_students_report/${this.track}/${this.date}/${this.id}`)
        .then(res => res.json())
        .then(res => {
          console.log(res);
          this.students = res.students;
          this.attendace_report = res.attendace_report;
          this.driver = res.driver;

        })
        .catch(err => console.log(err));
    },

   }
   
}
</script>

<style>

</style>
           