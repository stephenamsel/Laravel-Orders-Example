:javascript
	$(".content-wrapper").html("@yield('content')")
	//Recreating half of Turbolinks here, but have to specify this Layout in views to be loaded
	//Compatible with ajaxHandling.js (It had better be. I wrote that one a few minutes ago.)
