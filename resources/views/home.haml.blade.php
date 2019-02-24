@extends('layouts.app')

@section('content')
.container
	.row	
		@include('adminlte-templates::common.errors')
        .box.box-primary
            .box-body
                .row
                    = Form::open(['route' => 'customers.store'])
                        @include('customers.fields')
@endsection
