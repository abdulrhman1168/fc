<coupon></coupon>
<example></example>
<task-list></task-list>
<div class="row">
  <div class="container">
    <button @click="isVisible=true">Show Message</button>
  </div>
</div>
<message title="Hello World" body="lorem ipsum lorem ipsum" v-if="isVisible" @close="isVisible=false">
  <h1>Here</1>
</message>
