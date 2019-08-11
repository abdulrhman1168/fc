<template>


<div class='panel-body'>
<form @submit.prevent="AddReply" method="post" >     
                <div class="form-group ">
                <div class="col-xs-12">

                    <label for="ex3">{{trans('modules.note_reply')}}</label>
                    <textarea  class="form-control" id="ex3" type="text" v-model="note.reply" rows="5"> </textarea>
                    <span class="help-block" v-if="errors.reply" >
                    <strong class="text-danger" v-for="(value,index,key) in errors.reply" v-bind:key="key">{{value}}</strong>
                    </span>
                    
                </div>
                </div>

                <div class="form-group ">
                <div class="col-xs-1" style="margin-top:5px">
                    <label for="ex3"></label>
                    <button  class="btn green btn-block">{{trans('modules.save')}}</button>
                    
                </div>

                </div>
                <br>
                <br>
 



        </form>

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
            note:{
              reply:'',
              id:this.$route.params.id,
            },
            note_id:'',
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
    },

    AddReply()
    {
        this.errors = [];
        fetch(`/transport/notes/${this.note.id}/reply/store`, {
          method: 'post',
          body: JSON.stringify(this.note),
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
       this.note.reply = '';
       this.note.id = '';
     }


            
  }

}
</script>

<style>
.pagination
{
    float: left;
}
</style>
