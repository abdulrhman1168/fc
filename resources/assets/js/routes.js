import ByanReport from './components/transport/home/ByanReport.vue';
import AttendaceReport from './components/transport/home/AttendaceReport.vue';
import AttendingStudents from './components/transport/home/AttendingStudents.vue';
import DailyMovement from './components/transport/home/DailyMovement.vue';
import DailyMovementMorningReport from './components/transport/home/DailyMovementMorningReport.vue';
import DailyMovementEveningReport from './components/transport/home/DailyMovementEveningReport.vue';
import DailyMovementShow from './components/transport/dailymovment/DailymovmentShow.vue';
import SendTextMessages from './components/transport/home/SendTextMessages.vue';
import SMSMessages from './components/transport/home/SMSMessages.vue';
import ApologizesReasons from './components/transport/home/ApologizesReasons.vue';
import NoteReply from './components/transport/NoteReply.vue';

SMSMessages

const routes = [
  {
    path: '/vue/print_byan/:track/:date/:id',
    component: ByanReport
  },
  {
    path: '/vue/attend_students/:track/:date/:id',
    component: AttendingStudents
  },
  {
    path: '/vue/attendace_report/:track/:date/:id',
    component:  AttendaceReport
  },
  {
    path: '/vue/daily_movement/:date/:id',
    component: DailyMovement
  },
  {
    path: '/vue/daily_movement_morning_report/:date/:id',
    component: DailyMovementMorningReport
  },
  {
    path: '/vue/daily_movement_evening_report/:date/:id',
    component: DailyMovementEveningReport
  },
  {
    path: '/vue/send_text_messages/:track/:id',
    component: SendTextMessages
  },
  {
    path: '/vue/messages/show/:track/:date/:id',
    component: SMSMessages
  },
  {
    path: '/vue/reasons/:track/:date/:id',
    component: ApologizesReasons
  },

  {
    path: '/vue/daily_movment_show/:id/:date/:type',
    component: DailyMovementShow
  },
  {
    path: '/vue/notes/:id/reply',
    component: NoteReply
  },

]
export default routes