jQuery(document).ready(function($) {
  
    $('#calendar').fullCalendar({
      aspectRatio: 1.8,
      events: chainx_vars.events
    })

});