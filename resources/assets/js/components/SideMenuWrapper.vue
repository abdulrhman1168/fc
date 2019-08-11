<template>
  <ul class="page-sidebar-menu page-header-fixed page-sidebar-menu-closed " data-keep-expanded="false" data-auto-scroll="false" data-slide-speed="200" style="padding-top: 20px">
      <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
      <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
      <li class="sidebar-toggler-wrapper hide">
          <div class="sidebar-toggler">
              <span></span>
          </div>
      </li>
      <!-- END SIDEBAR TOGGLER BUTTON -->
      <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
      <li class="sidebar-search-wrapper">
          <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
          <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
          <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
          <!-- <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
              <a href="javascript:;" class="remove">
                  <i class="icon-close"></i>
              </a>
              <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search...">
                  <span class="input-group-btn">
                      <a href="javascript:;" class="btn submit">
                          <i class="icon-magnifier"></i>
                      </a>
                  </span>
              </div>
          </form> -->
          <!-- END RESPONSIVE QUICK SEARCH FORM -->
      </li>




      <li class="heading">
          <h3 class="uppercase">{{trans('messages.main_menu') }}
            <span style="color: white;" v-show="isLoading"><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i></span>
          </h3>
      </li>

      <side-menu-item v-for="app in apps" :model="app" :key="app.id">
      </side-menu-item>

  </ul>
</template>

<style>
</style>


<script>
// To Share Data accross views
window.CoreAppSharedData = {
  selectedApp: {}
}

export default {
  data() {
    return {
      apps: {},
      sharedData: CoreAppSharedData,
      isLoading: false
    };
  },
  methods: {
    loadApps() {
      this.isLoading = true;
      axios.get('/core/authorized-apps').then(response => {
        this.apps = response.data.data;
        this.isLoading = false;
      });
    }
  },
  created() {
    this.loadApps();
  }
}
</script>
