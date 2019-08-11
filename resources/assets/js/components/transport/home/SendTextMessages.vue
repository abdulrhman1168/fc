<template>
<div class="panel panel-default">

        <div class="panel-heading">{{trans('modules.send-message')}}</div>
        <form  @submit.prevent="sendMessage"  class="form-horizontal">
             <div class="form-group">
                <label class="control-label col-md-1">{{trans('modules.send')}} : </label>
                <div class="col-md-2">
                    <label class="radio-inline"><input type="radio" name="status" v-model="form.option" value="1">{{trans('modules.driver')}}</label>
                </div>
                <div class="col-md-2">
                    <label class="radio-inline"><input type="radio" name="status" v-model="form.option" value="2">{{trans('modules.students')}}</label>    
                </div>    
                <div class="col-md-2">
                    <label class="radio-inline"><input type="radio" name="status" v-model="form.option" value="12">{{trans('modules.all')}}</label>    
                </div> 
                <span class="help-block" v-if="errors.option" >
                <strong class="text-danger" v-for="(value,index,key) in errors.option" v-bind:key="key" v-text="value"></strong>
                </span>            
            </div>     

            <div class="form-group ">
                <label for="name" class="col-md-1 control-label"> {{trans('modules.message-content')}} : </label>
                <div class="col-md-6">
                    <textarea name="action_from_transport_office" v-model="form.message" cols="50" rows="10" class="form-control"></textarea>
                </div>
                <span class="help-block" v-if="errors.content" >
                <strong class="text-danger" v-for="(value,index,key) in errors.content" v-bind:key="key" v-text="value"></strong>
                </span> 
            </div>    
                
        <div class="panel-footer">
            <button  class="btn btn-success disabled" type="submit" style="pointer-events: all; cursor: pointer;"><i class="fa fa-check"></i> حفظ البيانات</button>
        </div>
        </form>
</div>
</template>

<script>
export default {
   data(){
        return {
            form:{

                id:this.$route.params.id,
                track:this.$route.params.track,
                option:'',
                message:'',
            },
            errors:[],
            driver:'',
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        }

    },
   methods:{
    sendMessage()
    {
        fetch('/transport/home/message/send', {
          method: 'post',
          body: JSON.stringify(this.form),
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
            alert(data.message);
          }

        })
        .catch(err => console.log(err));
    },
    clearForm()
    {
        this.errors = [];
        this.form.option='';
        this.form.message='';
    }
   }
   
}
</script>

<style>

</style>
           