<template>

</template>


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
