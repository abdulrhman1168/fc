<template>
<div id="printMe" >
<br><br><br>
<div class="container-fluid" dir="rtl">
        <h3 id="title-print">{{trans('modules.students-attendace-report')}}</h3>
<div class="panel panel-default">
<table class="table">
    <tbody><tr>
        <th>الكلية</th>
        <td>
            <p>{{ track.college_name}}</p>
        </td>
        <th>اسم السائق</th>
        <td>{{driver.name}}</td>
        <td rowspan="4" align="left"><img src="/assets/img/header-logo.png"></td>
    </tr>
    <tr>
        <th>رقم اللوحة</th>
        <td>{{driver.plate_number}}</td>
        <th>رقم الجوال</th>
        <td>{{driver.mobile}}</td>
    </tr>
    <tr>
        <th>رقم المسار</th>
        <td>
            <p>{{ track.track_number}}</p>
        </td>
        <th>كارت التشغيل</th>
        <td >
            <p>{{ driver.vehicle_number}}</p>
        </td>
    </tr>
    <tr>
        <th>اليوم</th>
        <td>{{dateName}}</td>
        <th>التاريخ</th>
        <td>{{date}}</td>
    </tr>
    <tr>
        <th colspan="2">خط السير</th>
        <td colspan="2" style="font-size: 12px;">
            <p >{{ track.track_ar}}</p>
        </td>
    </tr>
    </tbody></table>
    <br><br><br>
    <table class="table custom-table-bordered">
        <tbody>
            <tr style="background: #ccc">
            <th style="width: 15px;">م</th>
            <th style="width: 250px;">اسم الطالبة</th>
            <th>الكلية</th>
            <th>رقم هاتف ولي الأمر</th>
            <th>يوضع <i class="fa fa-check"></i> أمام الطالبة الحاضرة</th>
            <th>توقيع السائق على الغائبة</th>
            </tr>
            <tr v-for="(student,key) in students" v-bind:key="key">
                <td>{{++key}}</td>
                <td>  {{student.student_name}} </td>
                <td>{{student.faculty}}</td>
                <td>{{student.mobile_reference}}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
<br><br><br>
<table class="table">
    <tbody><tr>
        <th>توقيع السائق</th>
        <td></td>
        <th>وقت وصول الحافلة</th>
        <td width="150"></td>
        <td rowspan="6" width="120">
            <img alt="" src="/assets/img/transport_stump.png" width="120">
            المشرف العام على الإدارة العامة للخدمات <br> متعب محمد الميموني
        </td>
    </tr>
    <tr>
        <th>عدد الطالبات الحاضرات</th>
        <td></td>
        <th>عدد الطالبات المتغيبات</th>
        <td></td>
    </tr>
    <tr>
        <th>مصادقة المشرف</th>
        <td></td>
        <th>التوقيع</th>
        <td></td>
    </tr>
    <tr>
        <th>وقت وصول البيان</th>
        <td></td>
        <th>صفة مقدم البيان</th>
        <td></td>
    </tr>
    <tr>
        <th>مكتب إدارة النقل بالجامعة</th>
        <td></td>
        <th>وقت الوصول</th>
        <td></td>
    </tr>
    <tr>
        <th>اليوم</th>
        <td></td>
        <th>التاريخ</th>
        <td></td>
    </tr>
    <tr>
        <td colspan="5"><p>يمنع منعاً باتاً الوقوف لدى المحلات التجارية أثناء وجود الطالبات، كما يمنع نقل أي طالبة غير مدون اسمها في البيان ويعرض السائق نفسه للجزاءات.<br> وللاستفسار والملاحظات الاتصال على 0164041023 و 0164042217. مع تمنياتنا لجميع الطالبات التوفيق والنجاح. .</p></td>
    </tr>
</tbody></table>
<div style="float: left">ahmedfarghaly505</div>
    <div class="hidden-print">
            </div>
</div>

    
    
    
    
<br>
<br>
<br>
</div><!-- container-fluid -->
</div>
</template>

<script>
export default {
    data()
    {
        return {
            students:[],
            id:this.$route.params.id,
            date:this.$route.params.date,
            track_id:this.$route.params.track,
            driver:'',
            dateName:'',
            track:{},
        }

    },
    created()
    {
        this.getDriverReport();
    },
    updated()
    {
         this.print();
    },
    methods: {
    getDriverReport()
    {
         fetch(`/transport/home/get_driver_report/${this.track_id}/${this.date}/${this.id}`)
        .then(res => res.json())
        .then(res => {
          this.track = res.track;
          this.driver = res.driver;
          this.students = res.students;
          this.dateName = res.date_name
        })
        .catch(err => console.log(err));
    },

    print() {
      this.$htmlToPaper('printMe');
    }
  }
}
</script>
