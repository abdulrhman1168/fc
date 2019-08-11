<template>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Task List</div>

        <div class="panel-body">
          <form method="POST" action="/tasks" @submit.prevent="createTask()" @keydown="form.errors.clear($event.target.name)">
            <input type="text" id="name" name="name" v-model="form.name">
            <span class="has-error" v-text="form.errors.get('name')" v-if="form.errors.has('description')"></span>

            <button class="btn btn-primary" :disabled="errors.any()">Add Task</button>
          </form>

          <ul>
            <task v-for="task in tasks" :key="task.id">{{ task.task }}</task>
          </ul>
          <ul>
            <task v-for="task in remoteTasks" :key="task.id">{{ task }}</task>
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

import TaskList from '../components/TaskList.vue';

export default {
  components: {TaskList},
  
  data() {
    return {
        errors: new VueErrorsHandler(),

        form: new VueForm({
          name: '',
          description: ''
        }),
        tasks: [{
          id: 1,
          task: 'Task 1',
          completed: true
        },
        {
          id: 2,
          task: 'Task 2',
          completed: false
        },
      ],

      remoteTasks: []
    };
  },
  created() {
    axios.get('/tasks').then(response => this.remoteTasks = response.data);
  },
  methods: {
    createTask() {
      // create task
      this.form.submit('post', '/tasks')
               .then(data => alert('Handling it!'))
               .catch(errors => console.log(errors));
    },

    onSuccess(response) {
      alert(response.data.message);

      form.reset();
    }
  },
  computed: {

  }
}
</script>
