
import vSelect from 'vue-select'

Vue.component('v-select', vSelect);

Vue.component('example', require('./components/Example.vue').default);
Vue.component('task-list', require('./components/TaskList.vue').default);
Vue.component('task', require('./components/Task.vue').default);
Vue.component('message', require('./components/Message.vue').default);
// Vue.component('tree-base', require('./components/TreeBase.vue').default);
Vue.component('coupon', require('./components/Coupon.vue').default);
Vue.component('core-app', require('./components/CoreApp.vue').default);
Vue.component('core-app-wrapper', require('./components/CoreAppWrapper.vue').default);
Vue.component('core-app-form', require('./components/CoreAppForm.vue').default);
Vue.component('delete-core-app', require('./components/DeleteCoreApp.vue').default);
Vue.component('vue-input', require('./components/VueInput.vue').default);
Vue.component('permission-form', require('./components/PermissionForm.vue').default);
Vue.component('delete-permission', require('./components/DeletePermission.vue').default);
Vue.component('delete-action', require('./components/DeleteAction.vue').default);
Vue.component('attach-user-to-group', require('./components/AttachUserToGroup.vue').default);
Vue.component('side-menu-wrapper', require('./components/SideMenuWrapper.vue').default);
Vue.component('side-menu-item', require('./components/SideMenuItem.vue').default);
Vue.component('attach-domain-to-department', require('./components/AttachDomainDepartment.vue').default);

Vue.component('select2', require('./components/Select2Component.vue').default);
Vue.component('select2-multiple', require('./components/Select2MultipleComponent.vue').default);
Vue.component('add-items-to-need-request', require('./components/AddItemsToNeedRequest.vue').default);
Vue.component('multi-dept-select', require('./components/MultiDepartmentsSelect.vue').default);
// transport
Vue.component('add-city', require('./components/transport/AddCity.vue').default);
Vue.component('add-district', require('./components/transport/AddDistrict.vue').default);
Vue.component('add-track', require('./components/transport/AddTrack.vue').default);
Vue.component('add-vehicle', require('./components/transport/AddVehicles.vue').default);
Vue.component('add-driver', require('./components/transport/AddDriver.vue').default);
Vue.component('add-supervision-report', require('./components/transport/AddSupervision.vue').default);
Vue.component('show-supervision-report', require('./components/transport/showSupervision.vue').default);
Vue.component('home', require('./components/transport/Home.vue').default);
Vue.component('HomeSearchData', require('./components/transport/HomeSearchData.vue').default);
Vue.component('show-excuess', require('./components/transport/Excuess.vue').default);
Vue.component('dailymovment-index', require('./components/transport/dailymovment/DailymovmentIndex.vue').default);
Vue.component('create-activity', require('./components/transport/activites/AddActivity.vue').default);
Vue.component('all-activity', require('./components/transport/activites/Activites.vue').default);
Vue.component('show-activity', require('./components/transport/activites/ShowActivity.vue').default);
Vue.component('all-notes', require('./components/transport/StudentNotes.vue').default);



