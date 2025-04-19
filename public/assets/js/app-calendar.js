//________ FullCalendar
document.addEventListener('DOMContentLoaded', function() {
	var containerEl = document.getElementById('external-events-list');
	new FullCalendar.Draggable(containerEl, {
	  itemSelector: '.fc-event',
	  eventData: function(eventEl) {
		return {
		  title: eventEl.innerText.trim(),
		title: eventEl.innerText,
		className: eventEl.className + ' overflow-hidden '
		}
	  }
	});
	var calendarEl = document.getElementById('calendar');
	
	var calendar = new FullCalendar.Calendar(calendarEl, {
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'dayGridMonth,timeGridWeek,timeGridDay'
		  },
	   navLinks: true, // can click day/week names to navigate views
	  businessHours: true, // display business hours
	  editable: true,
	  selectable: true,
	  selectMirror: true,
	  droppable: true, // this allows things to be dropped onto the calendar
		  	
	  select: function(arg) {
		var title = prompt('Event Title:');
		if (title) {
		  calendar.addEvent({
			title: title,
			start: arg.start,
			end: arg.end,
			allDay: arg.allDay
		  })
		}
		calendar.unselect()
	  },
	  eventClick: function(arg) {
		if (confirm('Are you sure you want to delete this event?')) {
		  arg.event.remove()
		}
	  },

	  editable: true,
		eventSources: [sptCalendarEvents, sptBirthdayEvents, sptHolidayEvents, sptOtherEvents,],
		
	});
	calendar.render();
});	