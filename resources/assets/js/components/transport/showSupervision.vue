<template>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>التقارير اليومية لتقيم عمل الإشراف</h4>
    </div>
    <table class="table">
        <tbody>
            <tr>
                <th>عناصر التقييم</th>
            </tr>
            <tr>
                <th>{{trans('modules.how-many-you-enterd-system-today')}}: </th>
                <td>{{this.evaluation_data.login_no}}</td>
            </tr>
            <tr>
                <th>{{trans('modules.how-many-reports-uploaded')}}:</th>
                <td>{{this.evaluation_data.uploade_reports_no}}</td>
            </tr>
            <tr>
                <th>{{trans('modules.do-uploaded-daily-movement')}}:</th>
                <td v-if="this.evaluation_data.daily_movement_uploaded === '1'">نعم</td>
                <td v-else>لا</td>

            </tr>
            <tr>
                <th>{{trans('modules.how-many-reports-printed')}}:</th>
                <td>{{this.evaluation_data.printed_reports_no}}</td>
            </tr>
            <tr>
                <th>{{trans('modules.how-many-reports-get-from-system')}}:</th>
                <td>{{this.evaluation_data.reports_from_system_no}}</td>
            </tr>
        </tbody>
    </table>
    <div class="panel-heading">
        <h4>{{trans('modules.evaluate-supervision')}}</h4>
    </div>
    <form @submit.prevent="AddEvaluation" class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-md-2" for="computer_unit">تقيم وحدة الحاسب الألي 20 درجة</label>
            <div class="col-md-10">
                <input class="form-control " v-model="evaluation.computer_unit" type="number" min="1" max="20">
                <span class="help-block" v-if="errors.computer_unit" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.computer_unit" v-bind:key="key" v-text="value"></strong>
                </span> 
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2" for="m_unit">تقيم وحدة المراقبة الميدانية 20 درجة</label>
            <div class="col-md-10">
                <input class="form-control " v-model="evaluation.supervision_unit" type="number" min="1" max="20">
                <span class="help-block" v-if="errors.supervision_unit" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.supervision_unit" v-bind:key="key" v-text="value"></strong>
                </span> 
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-2" for="follow_unit">تقيم وحدة المتابعة 10 درجات</label>
            <div class="col-md-10">
                <input class="form-control " v-model="evaluation.follow_unit" type="number" min="1" max="10">
                <span class="help-block" v-if="errors.follow_unit" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.follow_unit" v-bind:key="key" v-text="value"></strong>
                </span> 
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-2" for="manager">تقيم مدير إدارة الخدمات 50 درجة</label>
            <div class="col-md-10">
                <input class="form-control " v-model="evaluation.manager" type="number" min="1" >
                <span class="help-block" v-if="errors.manager" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.manager" v-bind:key="key" v-text="value"></strong>
                </span> 
            </div>
        </div>
        
        <div class="panel-footer">
            <button class="btn btn-success" type="submit" style="pointer-events: all; cursor: pointer;"><i class="fa fa-check"></i> حفظ البيانات</button>
            <a class="btn btn-danger" href="/transport/evaluate"><i class="fa fa-times"></i> إلغاء</a>
        </div>
    </form>
</div>
    
</template>

<script>
export default {
    props: {
        lang: String,
    },
    created() {
        this.fetchReport();
    },
    data() {
        return {
            evaluation_data:'',
            evaluation:{
                supervision_unit: '',
                follow_unit: '',
                manager:'',
                computer_unit:'',
            },
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[]
        };
    },
  methods:{
    AddEvaluation() {
        fetch(window.location.pathname+'/store', {
          method: 'post',
          body: JSON.stringify(this.evaluation),
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
              this.clearForm();
              alert('evaluation Added');
            }

          })
          .catch(err => console.log(err));
      
    },
    fetchReport()
    {
        
        fetch(window.location.pathname + '?type=vue')
        .then(res => res.json())
        .then(res => {
          this.evaluation_data = res;
        })
        .catch(err => console.log(err));
    },
    clearForm() {
      this.evaluation.supervision_unit= '';
      this.evaluation.follow_unit='';
      this.evaluation.manager='';
      this.evaluation.computer_unit='';
      this.errors=[];
    },
    cancel(){
        this.clearForm();
    }      
  }

}
</script>
<style>
  .panel-body
  {
    font-size: 20px;
  }

  .form-group
  {
        margin-top: 18px;
  }
</style>
