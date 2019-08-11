<template>
<div class='panel-body'>
    <form @submit.prevent="AddEvaluation" class="form-horizontal">
    <div class="form-group">
        <label  class="col-sm-3  control-label">{{trans('modules.how-many-you-enterd-system-today')}}</label>
        <div class="col-sm-9">
        <input type="number" class="form-control" v-model="evaluation.login_no">
        <span class="help-block" v-if="errors.login_no" >
        <strong class="text-danger" v-for="(value,index,key) in errors.login_no" v-bind:key="key">{{value}}</strong>
        </span>
        </div>
    </div>

    <div class="form-group">
        <label  class="col-sm-3 control-label">{{trans('modules.how-many-reports-uploaded')}}</label>
        <div class="col-sm-9">
        <input type="number" class="form-control" v-model="evaluation.uploade_reports_no">
        <span class="help-block" v-if="errors.uploade_reports_no" >
        <strong class="text-danger" v-for="(value,index,key) in errors.uploade_reports_no" v-bind:key="key">{{value}}</strong>
        </span>
        </div>
    </div>

    <div class="form-group">
        <label  class="col-sm-3 control-label">{{trans('modules.do-uploaded-daily-movement')}}</label>
        <div class="col-sm-9">
            <label class="radio-inline "><input type="radio" v-model="evaluation.daily_movement_uploaded" name="u-d-m"  value="1">نعم</label>
            <label class="radio-inline"><input type="radio" v-model="evaluation.daily_movement_uploaded"  name="u-d-m" value="0"> لا</label>
            <span class="help-block" v-if="errors.daily_movement_uploaded" >
            <strong class="text-danger" v-for="(value,index,key) in errors.daily_movement_uploaded" v-bind:key="key">{{value}}</strong>
            </span>
        </div>
    </div>


    <div class="form-group">
        <label  class="col-sm-3 control-label">{{trans('modules.how-many-reports-printed')}}</label>
        <div class="col-sm-9">
        <input type="number" class="form-control" v-model="evaluation.printed_reports_no">
        <span class="help-block" v-if="errors.printed_reports_no" >
        <strong class="text-danger" v-for="(value,index,key) in errors.printed_reports_no" v-bind:key="key">{{value}}</strong>
        </span>
        </div>
    </div>



    <div class="form-group">
        <label  class="col-sm-3 control-label">{{trans('modules.how-many-reports-get-from-system')}}</label>
        <div class="col-sm-9">
        <input type="number" class="form-control" v-model="evaluation.reports_from_system_no">
        <span class="help-block" v-if="errors.reports_from_system_no" >
        <strong class="text-danger" v-for="(value,index,key) in errors.reports_from_system_no" v-bind:key="key">{{value}}</strong>
        </span>
        </div>
    </div>


    <div class="form-group" style="margin-top:50px;">
      <div class="col-sm-9">
        <strong class="text green">{{'هذا التقيم يعتبر تقيم يوميا لمراسلة العمل في مكاتب النقل بأمل أن يكون ذالك داعماً وسانداً لتنفيذ خطط العمل في نقل الطالبات ,, ولكم تحياتنا'}}</strong>
      </div>
      <div class="col-sm-3">
          <p><strong style="float:left">مدير إدارة الخدمات <br>متعب بن محمد الميموني </strong></p>
      </div>
    </div>



    <div class="form-group">
        <div class="col-sm-1">
        <button class="btn green btn-block">{{trans('modules.save')}}</button>
        </div>
        <div class=" col-sm-1">
        <button @click.prevent="cancel" class="btn red btn-block">{{trans('modules.cancel')}}</button>
        </div>
    </div>
    
    </form>
</div >

</template>

<script>
export default {
    props: {
        lang: String,
    },
    created() {
    },
    data() {
        return {
            evaluation:{
                login_no: '',
                uploade_reports_no: '',
                daily_movement_uploaded:'',
                printed_reports_no:'',
                reports_from_system_no:'',
            },
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            errors:[]
        };
    },
  methods:{
    AddEvaluation() {
        fetch('/transport/reports/supervision/store', {
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
    clearForm() {
      this.evaluation.login_no= '';
      this.evaluation.uploade_reports_no='';
      this.evaluation.daily_movement_uploaded='';
      this.evaluation.printed_reports_no='';
      this.evaluation.reports_from_system_no='';
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
