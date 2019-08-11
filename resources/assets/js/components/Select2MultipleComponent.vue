<template>
    <select multiple>
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
                vm.$emit('input', $(this).val())
            });
        },
        watch: {
          value(value) {
              if ([...value].sort().join(",") !== [...$(this.$el).val()].sort().join(",")) {
                  $(this.$el).val(value).trigger('change');
              }
          },
          options(options) {
            // update options
             $(this.$el).select2({ data: options })
          },
        },
        destroyed() {
          $(this.$el).off().select2('destroy')
        }
  }
</script>

<style>
select {
  min-width: 300px;
}

.select2 {
  min-width: 300px;
}
</style>