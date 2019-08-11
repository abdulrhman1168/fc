<template>
  <div class="form-group" v-bind:class="{ 'has-error': hasError }">
    <label for="title" class="col-md-4 control-label">{{ label }}</label>
    <div class="col-md-8">
      <input type="text" id="inputName" name="inputName" :value="model" class="form-control" @input="updateValue($event.target.value)">
      <span class="help-block" v-if="hasError">
         <strong>{{ errorMessage }}</strong>
      </span>
    </div>
  </div>
</template>

<style>

</style>


<script>

// Usage: <coupon v-model="coupon">

export default {
  props: {
    hasError: false,
    label: "",
    model: "",
    inputName: "",
    errorMessage: ""
  },
  methods: {
    updateValue(value) {
      this.$emit('input', value);
    }
  }
}
</script>
