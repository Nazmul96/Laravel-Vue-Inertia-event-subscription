  
  <script setup>
  import { ref,reactive,onMounted} from 'vue';
  import FullCalendar from '@fullcalendar/vue3';
  import dayGridPlugin from '@fullcalendar/daygrid';
  import timeGridPlugin from '@fullcalendar/timegrid';
  import interactionPlugin from '@fullcalendar/interaction';
  import { INITIAL_EVENTS, createEventId } from '../../event-utils';
  import {Head,useForm,usePage} from '@inertiajs/vue3';

  const options = { timeZone: 'Asia/Dhaka',year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit' };


  const props = defineProps({
    all_events: {
        type: Object,
        default: () => ({}),
    },
  });
  const eventRegister =useForm({
      event_id:"",
      event_name:"",
      user_name:'', 
      user_email:'', 
  })


  let open = ref(false)
  const calendarOptions = ref({
    plugins: [
      dayGridPlugin,
      timeGridPlugin,
      interactionPlugin,
    ],
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay',
    },
    initialView: 'dayGridMonth',
    initialEvents: props.all_events,
    editable: true,
    selectable: true,
    selectMirror: true,
    dayMaxEvents: true,
    weekends: true,
    select: handleDateSelect,
    eventClick: handleEventClick,
    eventsSet: handleEvents,
  });
  
  const currentEvents = ref([]);
  
  function handleWeekendsToggle() {
    calendarOptions.value.weekends = !calendarOptions.value.weekends;
  }
  
  function handleDateSelect(selectInfo) {
    
    // open.value = true;
    // let title = eventData.name;
    // let calendarApi = selectInfo.view.calendar;
  
    // calendarApi.unselect(); // clear date selection

    // if (title) {
    //   calendarApi.addEvent({
    //     id: createEventId(),
    //     title,
    //     start: selectInfo.startStr,
    //     end: selectInfo.endStr,
    //     allDay: selectInfo.allDay,
    //   });
    // }
  }
  
  function handleEventClick(clickInfo) {
      //console.log(clickInfo);
      open.value = true;
      eventRegister.event_name = clickInfo.event.title;
      eventRegister.event_id   = 1;
  }
  
  function handleEvents(events) {
    //currentEvents.value = events;
  }

  function saveEventRegister(selectInfo){
      if(eventRegister.user_name == '' || eventRegister.user_email == ''){
         alert("please fill the all filed")
      }
      open.value=false;
      eventRegister.post(`/event/registration`,{
        preserveScroll:true,
        onSuccess: () => {

        }
    })
  }

</script>

<template>

  <div v-if="eventRegister.hasErrors" class="error-messages" align="center">
      <ul>
        <li v-for="(error, key) in eventRegister.errors" :key="key" class="text-danger">{{ error }}</li>
      </ul>
    </div>
<div v-if="open" class="modal_data">

     <div class="event_name">
      <label for="">Event Name</label>
      <input type="hidden" class="form-control" v-model="eventRegister.event_id">
     <input type="text" class="form-control" v-model="eventRegister.event_name" required readonly>
     </div>
     <div class="start_date">
      <label for="">User Name</label>
      <input type="text" class="form-control" v-model="eventRegister.user_name" required>
     </div>
     <div class="event_name">
      <label for="">User Email</label>
     <input type="email" class="form-control" v-model="eventRegister.user_email" required>
     </div>
  <button @click="open = false" class="btn btn-sm btn-dark mt-2">Close</button>
  <button @click="saveEventRegister()" class="btn btn-sm btn-primary mt-2 ml-2">Save</button>
</div>
    <div class='demo-app'>

      <div class='demo-app-sidebar'>
        <div class='demo-app-sidebar-section'>
          <h2>Instructions</h2>
          <ul>
            <li>Select dates and you will be prompted to create a new event</li>
          </ul>
        </div>
        <div class='demo-app-sidebar-section'>
          <label>
            <input
              type='checkbox'
              :checked='calendarOptions.weekends'
              @change='handleWeekendsToggle'
            />
            toggle weekends
          </label>
        </div>
        <div class='demo-app-sidebar-section'>
          <h2>All Events ({{ currentEvents.length }})</h2>
        </div>
      </div>
      <div class='demo-app-main'>
        <FullCalendar
          class='demo-app-calendar'
          :options='calendarOptions'
        >
          <template v-slot:eventContent='arg'>
            <b>{{ arg.timeText }}</b>
            <i>{{ arg.event.title }}</i>
          </template>
        </FullCalendar>
      </div>
    </div>
  </template>

  
  <style scoped>
  .modal_data {
    position: fixed;
    z-index: 999;
    top: 20%;
    left: 50%;
    width: 300px;
    margin-left: -150px;
    background-color: #ccc; /* Set your desired background color */
    border: 2px solid #fff;
    padding: 15px;
 }
  h2 {
    margin: 0;
    font-size: 16px;
  }
  
  ul {
    margin: 0;
    padding: 0 0 0 1.5em;
  }
  
  li {
    margin: 1.5em 0;
    padding: 0;
  }
  
  b { /* used for event dates/times */
    margin-right: 3px;
  }
  
  .demo-app {
    display: flex;
    min-height: 100%;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }
  
  .demo-app-sidebar {
    width: 300px;
    line-height: 1.5;
    background: #eaf9ff;
    border-right: 1px solid #d3e2e8;
  }
  
  .demo-app-sidebar-section {
    padding: 2em;
  }
  
  .demo-app-main {
    flex-grow: 1;
    padding: 3em;
  }
  
  .fc { /* the calendar root */
    max-width: 1100px;
    margin: 0 auto;
  }
  </style>
  