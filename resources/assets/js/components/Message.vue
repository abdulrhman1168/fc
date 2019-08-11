<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            {{title}}
            <button class="close" @click="$emit('close')">x</button>
          </div>

          <div class="panel-body">
            <ul>
              {{body}}
              <slot></slot>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>

</style>

<script>
export default {
  props: ['title', 'body'],
  data() {
  return {
    isVisible: true
  }
  },
  mounted() {},
  methods: {
    hideModal() {
      this.isVisible = !this.isVisible;
    }

  },
  computed: {

  }
}
</script>
