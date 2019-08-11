<template>
 <div>
     <select2-multiple :options="departmentsOptions" v-model="selectedDepartments">
    </select2-multiple>

    <span v-for="id in selectedDepartments" :key="id">
        <input name="departments[]" type="hidden" :value="id">
    </span>
 </div>

</template>



<script>


export default {
  mounted() {
        this.loadDepartments();
    },
    data() {
      return {
        selectedDepartments: [],
        departmentsOptions: []
      };
    },

    methods: {
        loadDepartments() {
            axios.get('/core/departments/main-types').then(response => {
                var data = [];
                
                data.push({ id: 0, text: "" });
                response.data.forEach((department, index) => {
                    data.push({ id: department.id , text: department.name });
                });

                this.departmentsOptions = data;
            }); 
        }
    }
}
</script>
