<template>
<div class="col-md-12">
  <div class="col-md-12">


      <div class="row">
        <div class="col-md-12">
          <div class="col-md-5">

          </div>
          <div class="col-md-5">

          </div>
          <div class="col-md-2">

          </div>
        </div>
      </div>
      <br/>


  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-domain"></i>
           {{trans('messages.domains')}}
        </div>
         <div class="panel-body">
           <div class="col-md-10">
             <span v-show="isLoading">
               {{ trans('messages.loading') }}
               <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
             </span>
             <form @submit.prevent="attachDomain()" @keydown="form.errors.clear($event.target.name)">
             <table class="table table-bordered">
               <tbody>
                 <tr>
                   <th>{{trans('messages.domain_start')}}</th>
                   <th>{{trans('messages.domain_end')}}</th>
                    <th></th>
                 </tr>
                 <tr>
                   <td>
                     <div class="form-group" v-bind:class="{ 'has-error': form.errors.has('start') }">
                       <label for="title" class="col-md-2 control-label">{{ trans('messages.domain_start') }}</label>
                       <div class="col-md-8">
                         <input type="number" id="name" name="name" v-model="form.start" class="form-control">
                         <span class="help-block" v-if="form.errors.has('start')">
                             <strong>{{ form.errors.get('start') }}</strong>
                          </span>
                       </div>
                     </div>
                   </td>
                   <td>
                     <div class="form-group" v-bind:class="{ 'has-error': form.errors.has('end') }">
                       <label for="title" class="col-md-2 control-label">{{ trans('messages.domain_end') }}</label>
                       <div class="col-md-8">
                         <input type="number" id="name" name="name" v-model="form.end" class="form-control">
                         <span class="help-block" v-if="form.errors.has('end')">
                             <strong>{{ form.errors.get('end') }}</strong>
                          </span>
                       </div>
                     </div>
                   </td>
                   <td>
                     <button class="btn btn-primary">{{ trans('messages.action_add') }}</button>
                   </td>
                 </tr>
                 <tr v-for="domain in domains" :key="domain.id">
                    <td>{{domain.start}}</td>
                    <td>{{domain.end}}</td>
                    <td>
                      <button type="button" class="btn btn-danger" @click="detachDomain(domain)">
                        {{trans('messages.action_delete')}}
                      </button>
                      <!-- <button type="button" class="btn btn-info" @click="editDomain(domain)">
                        {{trans('messages.action_edit')}}
                      </button> -->
                    </td>
                 </tr>
               </tbody>
             </table>
           </form>
           </div>
         </div>
        <div class="panel-footer">
        </div>
    </div>
    <div v-if="displayModal">
      <transition name="modal">
        <div class="modal" style="display: block">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <span v-show="isLoading"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></span>
                <slot name="header"></slot>
              </div>

              <div class="modal-body">
                <div class="row">
                  <form @submit.prevent="updateDomain()" @keydown="updateForm.errors.clear($event.target.name)">
                    <div class="col-md-12">
                      <div class="col-md-6">
                        <div class="form-group" v-bind:class="{ 'has-error': updateForm.errors.has('start') }">
                          <label for="title" class="col-md-2 control-label">{{ trans('messages.domain_start') }}</label>
                          <div class="col-md-8">
                            <input type="number" id="name" name="name" v-model="updateForm.start" class="form-control">
                            <span class="help-block" v-if="updateForm.errors.has('start')">
                                <strong>{{ updateForm.errors.get('start') }}</strong>
                             </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group" v-bind:class="{ 'has-error': updateForm.errors.has('end') }">
                          <label for="title" class="col-md-2 control-label">{{ trans('messages.domain_end') }}</label>
                          <div class="col-md-8">
                            <input type="number" id="name" name="name" v-model="updateForm.end" class="form-control">
                            <span class="help-block" v-if="updateForm.errors.has('end')">
                                <strong>{{ updateForm.errors.get('end') }}</strong>
                             </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>

                <slot name="body"></slot>
              </div>

              <div class="modal-footer">
                <!-- :disabled="form.errors.any()" -->
                <button class="btn btn-primary"  @click="updateDomain()" :disabled="isLoading">{{ trans('messages.save') }}</button>
                <button class="btn btn-danger"  @click="cancelUpdate()">{{ trans('messages.action_cancel') }}</button>
                <slot name="footer"></slot>
              </div>
            </div>
          </div>
        </div>
      </transition>
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
    departmentId: String,
    addUrl: String,
    destroyUrl: String,
    updateUrl: String,
    domainsUrl: String
  },
  data() {
    return {
      form: new VueForm({
        department_id: this.departmentId,
        start: null,
        end: null,
        id: null
      }),
      deleteForm: new VueForm({
        department_id: this.departmentId,
        start: null,
        end: null,
        id: null
      }),
      updateForm: new VueForm({
        department_id: this.departmentId,
        start: null,
        end: null,
        id: null
      }),
      options: [],
      domains: [],
      isLoading: false,
      displayModal: false,
      selectedDomain: null
    };
  },
  mounted() {},
  created() {
    this.loadDomains();
  },
  methods: {
    loadDomains() {
      this.isLoading = true;
      axios.get(this.domainsUrl).then(response => {
        this.domains = response.data;
        this.isLoading = false;
      });
    },
    attachDomain() {
      this.isLoading = true;
      this.form.submit('post', this.addUrl)
        .then(success => {
          this.savingError = false
          this.domains.push(success);

          this.form = new VueForm({
            department_id: this.departmentId,
            start: "",
            end: "",
            id: null
          });

          this.isLoading = false;
        })
        .catch(errors => this.isLoading = false);
    },
    getOptions(search, loading) {
      loading(true)
      axios.get('/core/domains-search', {
         query: search
      }).then(resp => {
         this.options = resp.data
         loading(false)
      })
    },
    setDomain(domain) {
      this.form.id = domain.id;
    },
    detachDomain(domain) {
      this.isLoading = true;
      var url = this.destroyUrl + '/' + domain.id;
      var r = confirm(lodashLib.get(window.i18n, 'messages.are_you_sure'));

      if (r == true) {
        this.deleteForm.id = domain.id;

          this.deleteForm.submit('delete', url)
          .then(success => {
            this.savingError = false


            for(var i = 0; i < this.domains.length; i++) {
                if (this.domains[i].id == domain.id) {
                    this.domains.splice(i, 1);
                    break;
                }
            }

            this.deleteForm = new VueForm({
              department_id: this.departmentId,
              id: null
            });
            this.isLoading = false;

          })
          .catch(errors => {
            this.isLoading = false;
            alert(lodashLib.get(window.i18n, 'messages.error_during_delete'));
          });
      }
    },
    editDomain(domain) {
      this.displayModal = true;
      this.selectedDomain = domain;
      this.updateForm = new VueForm({
        department_id: this.departmentId,
        start: domain.start,
        end: domain.start,
        id: null
      });
    },
    cancelUpdate() {
      this.displayModal = false;
    },
    updateDomain() {
      this.isLoading = true;
      var url = this.updateUrl + '/' + this.selectedDomain.id;
      this.updateForm.submit('put', url)
      .then(success => {

        for(var i = 0; i < this.domains.length; i++) {
            if (this.domains[i].id == this.selectedDomain.id) {
                this.domains[i] = success;
            }
        }

        this.updateForm = new VueForm({
          department_id: this.departmentId,
          start: "",
          end: "",
          id: null
        });

        this.displayModal = false;
        this.isLoading = false;
      })
      .catch(errors => this.isLoading = false);
    }
  },
  computed: {
  }
}
</script>
