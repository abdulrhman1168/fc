<template>
<span>
<button class="btn btn-xs btn-danger">{{ trans('messages.action_delete') }}</button>
<transition name="modal">
  <div class="modal" style="display: block" v-show="displayModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
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
            <form @submit.prevent="deleteObject()" @keydown="form.errors.clear($event.target.name)">

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
          <button class="btn btn-danger"  @click="deleteObject()">{{ trans('messages.yes') }}</button>
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </div>
</transition>
</span>
</template>

<style>

</style>


<script>
export default {
  props: {
    routeAction: String,
    displayModal: false
  },
  computed: {},
  data() {
    return {
      form: new VueForm(this.model),
      savedSuccessfully: false,
      savingError: false,
      sharedData: CoreAppSharedData,
    };
  },
  created() {
    this.displayForm = true;
    this.savingError = false
    this.savedSuccessfully = false;
    this.form = new VueForm({});
  },
  methods: {
    deleteObject() {
      this.form.submit(routeAction)
               .then(success => {
                 this.savingError = false
                 this.savedSuccessfully = true;
                 window.reload();
               })
               .catch(errors => this.savingError = true);
    }
  }
}
</script>
