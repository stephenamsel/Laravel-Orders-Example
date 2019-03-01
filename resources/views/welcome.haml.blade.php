@extends('layouts.app')
- // Note - Using HAML
@section('content')
.container
  .row	
    @include('adminlte-templates::common.errors')
    .box.box-primary
      .box-body
        .row
          {!! Form::open(['route' => 'customers.store', 'class' => 'ajax']) !!}
          {{ csrf_field() }}
          - // ajax class is handled in resources/js/ajaxHandling.js - It makes a form run over Ajax
          .row{style: 'padding: 5px'}
            .col-xs-4
              %strong
                Email:
            .col-xs-8
              {!! Form::text('email') !!}
          .row{style: 'padding: 5px'}
            .col-xs-4
              %strong
                Name:
            .col-xs-8
              {!! Form::text('name') !!}
          .row{style: 'padding: 5px'}
            .col-xs-4
              %strong
                I already have my DNA Data:
            .col-xs-8
              {!! Form::checkbox('has_dna') !!}    
          {!! Form::submit('Submit Info') !!}  
          {!! Form::close() !!}

:javascript
  // This was all in a JS file, required in app.js which is called on the Layout, but I couldn't get this JS to load.
  // Now it's inline in the page.
  
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(function(){
      $(".ajax").each(function(index, value){
      
      $(this).submit(function(e){submitAsAjax(e)});		
    });	
  });
	
  function getData(inputs){
    out = {};
    inputs.each(function(index, value){
      a = $(this).children("option:selected").val(); //Handle Select Fields
      if(typeof(a) == 'undefined'){
        a = $(this).val();
      }
      out[this.getAttribute('name')] = a;		
    });
    return out;
  };

  function submitAsAjax(e){
    e.preventDefault();
    form = e.target;
    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}	});
    inputs = $(form).find("input").add($(form).find('select'));
    $.ajax({
        type:form.getAttribute('method'),
        url:form.getAttribute('action'),
        data:getData(inputs),
        success:function(response){
          
        //This should be handled by the standard Ajax Response set below, but for some reason it just doens't f!@#ing run
        //It runs fine when entered in the console, but not from inside a Script tag in Laravel, 
        //either as an external JS file or inline
      }
    });
  };
  // This one is not from that page. It's just a setup I use all the time.
  function ajaxRespond(){
    $( document ).off('ajaxComplete'); // Eliminate old settings to prevent duplicate responses
    $( document ).ajaxComplete(function( event, request, settings ) {eval(request.responseText);});
  };
  $(function(){ajaxRespond();})
@endsection

