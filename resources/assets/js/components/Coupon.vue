<template>
 <!-- <input placeholder="Enter your coupon code" @blur="onCouponApplied"> -->
 <input type="text" :value="code" @input="updateCode($event.target.value)">

</template>

<style>

</style>


<script>

// Usage: <coupon v-model="coupon">

export default {
  data() {
    return {}
  },
  methods: {
    onCouponApplied() {
      VueEventHandler.fire('applied');
    },
    updateCode(code) {
      this.$emit('input', code);
    }
  },
  computed: {

  }
}
</script>
