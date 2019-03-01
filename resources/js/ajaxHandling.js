// Framework to generate AJAX forms, recreating Rails' "remote" option. Surprised there is no package for that - Stephen
//Most code is from https://hdtuto.com/article/php-laravel-ajax-form-submit-example
//Just generalizing it and running data through FormInput object
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
alert("Loaded Ajax Setup!");
$(function(){
	$(".ajax").each(function(index, value){
		inputs = $(this).find("input").or(($this).find('select'));
		AjaxForm = {};
		AjaxForm['data'] = getData(inputs);
		AjaxForm['method'] = this.getAttribute('method');
		AjaxForm['action'] = this.getAttribute('action');
		$(this).submit(submitAsAjax(e));		
	});	
});

function getData(inputs){
	out = {};
	inputs.each(function(index, value){
		a = $(this).children("option:selected").val(); //Handle Select Fields
		if(a == 'undefined' || a == 'null'){
			a = $(this).val();
		}
		out[this.getAttribute('name')] = a;		
	});
	return out;
};

function submitAsAjax(e){
	e.preventDefault();
	$.ajax({
		type:AjaxForm.method,
		url:AjaxForm.action,
		data:AjaxForm.data,
		success:function(response){
			
			//This is handled by the standard Ajax Response set below
		}
	});
};
// This one is not from that page. It's just a setup I use all the time.
function ajaxRespond(){
	$( document ).off('ajaxComplete'); // Eliminate old settings to prevent duplicate responses
	$( document ).ajaxComplete(function( event, request, settings ) {eval(request.responseText);});
};
$(function(){ajaxRespond();});
