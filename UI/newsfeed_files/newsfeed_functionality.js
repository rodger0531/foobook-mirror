$(document).ready(function() {
	$("#foobook_menu .foobook_dropdown #settings_menu .settings_dropdown").hoverIntent({
		interval: 150, // milliseconds delay before onMouseOver
		over: option_menu_show, 
		timeout: 500, // milliseconds delay before onMouseOut
		out: option_menu_hide
	});
});