<template>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Example Component</div>

        <div class="panel-body">
          <ul>
            <li v-for="name in names" v-text="name"></li>
          </ul>
          <input class="form-control" v-model="newName">
          <button @click="toggleClass" :title="title" :class="{'is-loading': isLoading }">Hover me</button>
          <button @click="enableDisable" :disabled="isDisabled">Disable</button>
          <h1>{{ reversedMessage }}</h1>

          <h3>Tasks</h3>
          <ul>
            <li v-for="task in tasks" v-text="task.description"></li>
          </ul>

          <h3>Incomplete Tasks</h3>
          <ul>
            <li v-for="task in incompleteTasks" v-text="task.description"></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<style>
.is-loading {
  background-color: red;
}
</style>

<script>
export default {
  data() {
    return {
      names: ['Ahmed', 'Shawky', 'Ibrahim', 'Rayan'],
      newName: '',
      title: 'Ahmed',
      isLoading: false,
      isDisabled: false,
      message: 'Hello World',
      tasks: [{
          description: 'Task 1',
          completed: true
        },
        {
          description: 'Task 2',
          completed: false
        },
        {
          description: 'Task 3',
          completed: false
        },
        {
          description: 'Task 4',
          completed: false
        },
        {
          description: 'Task 5',
          completed: true
        },
        {
          description: 'Task 5',
          completed: true
        }
      ]
    }
  },
  mounted() {},

  created() {
    VueEventHandler.listen('applied', () => alert("Handling it!"));
  },
  methods: {
    addName() {
      this.names.push(this.newName);
      this.newName = '';
    },
    toggleClass() {
      this.isLoading = true;
    },
    enableDisable() {
      this.isDisabled = true;
    }
  },
  computed: {
    reversedMessage() {
      return this.message.split('').reverse().join('');
    },
    incompleteTasks() {
      return this.tasks.filter(task => ! task.completed);
    }
  }
}
</script>
