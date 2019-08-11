<template>
    <select class="vue-select-custom">
       <slot></slot>
    </select>
</template>

<script>
    export default {
        props: ['options', 'value'],
        mounted() {
            var vm = this
            $(this.$el)
              // init select2
              .select2({ data: this.options })
              .val(this.value)
              .trigger('change')
              // emit event on change.
              .on('change', function () {
                vm.$emit('input', this.value)
              })
        },
        watch: {
          value(value) {
          // update value
          $(this.$el)
            .val(value)
            .trigger('change')
          },
          options(options) {
            // update options
            $(this.$el).empty().select2({ data: options })
          },
        },
        destroyed() {
          $(this.$el).off().select2('destroy')
        }
  }
</script>

<style>
.vue-select-custom {
  min-width: 300px;
}

.vue-select-custom {
  max-width: 300px;
}

.select2 {
  min-width: 300px;
}
</style>