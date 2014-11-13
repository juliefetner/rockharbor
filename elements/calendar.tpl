<div class="clearfix"></div>
<div id="calendar"></div>
<script>jQuery('#calendar').fullCalendar({
	header: {
		left: '',
		center: 'prev,title,next',
		right: ''
	},
	buttonText: {
		prev: '&lt;',
		next: '&gt;'
	},
	events: function(start, end, callback) {
		jQuery.ajax({
			url: 'https://core.rockharbor.org/dates/calendar<?php echo !empty($id) ? "/Campus:$id" : null; ?>/full.json?start='+Math.round(start.getTime()/1000)+'&end='+Math.round(end.getTime()/1000),
			dataType: 'jsonp',
			success: callback
		});
	}
});</script>
