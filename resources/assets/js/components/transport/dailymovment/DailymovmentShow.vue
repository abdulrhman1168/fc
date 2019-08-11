<template>
<div class="panel panel-default">
                    <div class="panel-heading">
          {{trans('modules.daily-movement')}}
        </div> 
        <div>       
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{trans('modules.date')}}</th>
                    <th>{{trans('modules.college')}}</th>
                    <th>{{trans('modules.duration')}}</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{dailymovment[0].hijri_date}}</td>
                    <td> {{dailymovment[0].college_name}}</td>
                    <td v-if="dailymovment[0].duration == '1'"> {{trans('modules.morning')}}</td>
                    <td v-else> {{trans('modules.evening')}}</td>

                </tr>
            </tbody>
        </table>
        </div>
        <br><br><br>

                <div>       
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{trans('modules.driver')}}</th>
                    <th>{{trans('modules.track')}}</th>
                    <th>{{trans('modules.problems')}}</th>
                    <th>{{trans('modules.notes')}}</th>

                </tr>
            </thead>
            <tbody>
                <tr v-for="report in dailymovment" v-bind:key="report.driver_id">
                    <td>{{report.name}}</td>
                    <td> {{report.track_ar}}</td>
                    <td> 
                        <p v-for="(status,key) in report.status" v-bind:key="key">{{trans(`modules.data-${key}`)}}</p>

                    </td>
                    <td> 
                        <p v-for="(note,key) in report.notes" v-bind:key="key">{{note}}</p>
                    </td>

                </tr>
            </tbody>
        </table>
        </div>
</div>
</template>

<script>
export default {
   data(){
        return {
            dailymovment:[],
            propertise:[],
            id:this.$route.params.id,
            date:this.$route.params.date,
            type:this.$route.params.type,
        }

    },
    created()
    {
        this.getDailyMovmentCollegeReport();
    },
   methods:{
    getDailyMovmentCollegeReport()
    {
         fetch(`/transport/get_daily_movment_college/${this.id}/${this.date}/${this.type}`)
        .then(res => res.json())
        .then(res => {
          this.dailymovment = res;
        })
        .catch(err => console.log(err));
    },

   }
   
}
</script>

<style>

</style>
           