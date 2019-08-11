<template>
<transition name="modal">
  <div class="modal" style="display: block">
    <div class="modal-dialog" role="document">
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
            <form @submit.prevent="deletePermission()" @keydown="form.errors.clear($event.target.name)">

              <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                   <h2>{{ trans('messages.are_you_sure') }}</h2>
                 </div>
              </div>

              <div class="alert alert-danger" v-if="form.errors.has('message')">
                 <strong>{{ form.errors.get('message') }}</strong>
              </div>

            </form>
          </div>

          <slot name="body"></slot>
        </div>

        <div class="modal-footer">
          <!-- :disabled="form.errors.any()" -->
          <button class="btn btn-danger"  @click="deletePermission()">{{ trans('messages.yes') }}</button>
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
      permission: {},
      isLoading: false
    };
  },
  created() {
    VueEventHandler.listen('DeletePermission', (permission) => {
      this.displayForm = true;
      this.savingError = false
      this.savedSuccessfully = false;
      this.permission = permission;
      this.form = new VueForm(permission);
    });
  },
  methods: {
    deletePermission() {
      this.isLoading = true;
      this.form.submit('delete', '/core/permissions/' + this.form.id)
               .then(success => {
                 this.savingError = false
                 this.savedSuccessfully = true;
                 VueEventHandler.fire('PermissionDeleted', this.permission);
                 this.isLoading = false;
               })
               .catch(errors => {
                 this.savingError = true;
                 this.isLoading = false;
               });
    }
  }
}
</script>
