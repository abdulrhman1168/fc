<template>
<transition name="modal">
  <div class="modal" style="display: block">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <span v-show="isLoading"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></span>
          <slot name="header"></slot>
          <div class="alert alert-success" v-if="savedSuccessfully">
            {{ trans('messages.saved_successfully') }}
          </div>
          <div class="alert alert-danger" v-if="savingError">
            {{ trans('messages.review_errors') }}
          </div>
        </div>

        <div class="modal-body">
          <div class="row">
            <form @submit.prevent="savePermission()" @keydown="form.errors.clear($event.target.name)">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group" v-bind:class="{ 'has-error': form.errors.has('access_level') }">
                    <label for="title" class="col-md-4 control-label">{{ trans('messages.access_level') }}</label>
                    <div class="col-md-8">
                      <select v-model="form.access_level" class="form-control">
                          <option v-for="level in accessLevels" :key="level.id" v-bind:value="level.id">{{level.name}}</option>
                       </select>
                      <span class="help-block" v-if="form.errors.has('access_level')">
                          <strong>{{ form.errors.get('access_level') }}</strong>
                       </span>
                    </div>
                  </div>
                </div>
              </div>
              <br/>

            </form>
          </div>

          <slot name="body"></slot>
        </div>

        <div class="modal-footer">
          <!-- :disabled="form.errors.any()" -->
          <button class="btn btn-primary" @click="savePermission()">{{ trans('messages.save') }}</button>
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </div>
</transition>
</template>

<style>

</style>


<script>
export default {
  props: {
    model: Object
  },
  computed: {},
  data() {
    return {
      form: new VueForm(this.model),
      savedSuccessfully: false,
      savingError: false,
      sharedData: CoreAppSharedData,
      accessLevels: [],
      selectedAccessLevel: null,
      permission: {},
      permissionableType: null,
      permissionableId: null,
      isLoading: false
    };
  },
  created() {
    VueEventHandler.listen('AddNewPermisison', (data) => {
      this.displayForm = true;
      this.savingError = false
      this.savedSuccessfully = false;
      this.permissionableType = data.permissionableType;
      this.permissionableId = data.permissionableId;

      var self = this;
      var attrs = {
        is_new_record: true,
        app_id: this.sharedData.selectedApp.id,
        permissionable_type: data.permissionableType,
        permissionable_id: data.permissionableId,
        access_level: ""
      };
      this.form = new VueForm(attrs);
    });

    VueEventHandler.listen('EditPermission', (data) => {
      this.displayForm = true;
      this.savingError = false
      this.savedSuccessfully = false;
      this.permissionableType = data.permissionableType;
      this.permissionableId = data.permissionableId;

      this.form = new VueForm(data.permission);
    });

    //Load access levels
    axios.get('/core/access-levels').then(response => this.accessLevels = response.data);
  },
  methods: {
    savePermission() {
      // create permission
      this.isLoading = true;
      var baseURL = '/core/' + this.permissionableType + '/' + this.permissionableId + '/permissions';

      if (this.form.is_new_record) {
        this.form.submit('post', baseURL)
          .then(success => {
            this.savingError = false
            this.savedSuccessfully = true;
            VueEventHandler.fire('NewPermissionAdded', success);
            this.isLoading = false;
          })
          .catch(errors => {
            this.savingError = true;
            this.isLoading = false;
          });
      } else {
        this.form.submit('put', baseURL + '/' + this.form.id)
          .then(success => {
            this.savingError = false
            this.savedSuccessfully = true;
            VueEventHandler.fire('PermissionUpdated', success);
            this.isLoading = false;
          })
          .catch(errors => {
            this.savingError = true;
            this.isLoading = false;

          });
      }
    }
  }
}
</script>
