<template>
<div class="col-md-12">
  <div class="col-md-12">
    <form @submit.prevent="attachUser()" @keydown="form.errors.clear($event.target.name)">

      <div class="row">
        <div class="col-md-12">
          <div class="form-group" v-bind:class="{ 'has-error': form.errors.has('user_id') }">
            <label for="title" class="col-md-2 control-label">{{ trans('messages.user') }}</label>
            <div class="col-md-8">
              <v-select
                        :debounce="250"
                        :on-search="getOptions"
                      	:options="options"
                      	placeholder=""
                        :on-change="setUser"
                      	label="user_name">
              </v-select>
              <span class="help-block" v-if="form.errors.has('user_id')">
                  <strong>{{ form.errors.get('user_id') }}</strong>
               </span>
            </div>
            <div class="col-md-2">
              <button class="btn btn-primary">{{ trans('messages.action_add') }}</button>
            </div>
          </div>
        </div>
      </div>
      <br/>

    </form>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-user"></i>
           {{trans('messages.users')}}
        </div>
         <div class="panel-body">
           <div class="col-md-10">
             <span v-show="isLoading">
               {{ trans('messages.loading') }}
               <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
             </span>
             <table class="table table-bordered">
               <tbody>
                 <tr>
                   <th>{{trans('messages.general_name')}}</th>
                    <th></th>
                 </tr>
                 <tr v-for="user in users" :key="user.user_id">
                    <td>{{user.user_name}}</td>
                    <td>
                      <button class="btn btn-danger" @click="detachUser(user)">
                        {{trans('messages.action_delete')}}
                      </button>
                    </td>
                 </tr>
               </tbody>
             </table>
           </div>
         </div>
        <div class="panel-footer">
        </div>
    </div>
  </div>
</div>
</template>

<style>

</style>

<script>
import vSelect from "vue-select"

export default {
  components: {vSelect},
  props: {
    groupId: String,
    attachUrl: String,
    detachUrl: String,
    usersUrl: String
  },
  data() {
    return {
      form: new VueForm({
        group_id: this.groupId,
        user_id: null
      }),
      deleteForm: new VueForm({
        group_id: this.groupId,
        user_id: null
      }),
      options: [],
      users: [],
      isLoading: false
    };
  },
  mounted() {},
  created() {
    this.loadUsers();
  },
  methods: {
    loadUsers() {
      this.isLoading = true;
      axios.get(this.usersUrl).then(response => {
        this.users = response.data;
        this.isLoading = false;
      });
    },
    attachUser() {
      this.form.submit('post', this.attachUrl)
        .then(success => {
          this.savingError = false
          this.savedSuccessfully = true;
          this.users.push(success);

          this.form = new VueForm({
            group_id: this.groupId,
            user_id: null
          });

        })
        .catch(errors => this.savingError = true);
    },
    getOptions(search, loading) {
      loading(true)
      axios.get('/core/users-search', {
         query: search
      }).then(resp => {
         this.options = resp.data
         loading(false)
      })
    },
    setUser(user) {
      this.form.user_id = user.user_id;
    },
    detachUser(user) {
      var r = confirm(lodashLib.get(window.i18n, 'messages.are_you_sure'));

      if (r == true) {
        this.deleteForm.user_id = user.user_id;

          this.deleteForm.submit('delete', this.detachUrl + '/' + user.user_id)
          .then(success => {
            this.savingError = false
            this.savedSuccessfully = true;

            for(var i = 0; i < this.users.length; i++) {
                if (this.users[i].user_id == user.user_id) {
                    this.users.splice(i, 1);
                    break;
                }
            }

            this.form = new VueForm({
              group_id: this.groupId,
              user_id: null
            });

          })
          .catch(errors => this.savingError = true);
      }
    }
  },
  computed: {
  }
}
</script>
