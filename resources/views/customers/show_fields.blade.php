<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $customer->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $customer->name !!}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $customer->email !!}</p>
</div>

<!-- Shopify Id Field -->
<div class="form-group">
    {!! Form::label('shopify_id', 'Shopify Id:') !!}
    <p>{!! $customer->shopify_id !!}</p>
</div>

<!-- Stripe Id Field -->
<div class="form-group">
    {!! Form::label('stripe_id', 'Stripe Id:') !!}
    <p>{!! $customer->stripe_id !!}</p>
</div>

<!-- Dna File Path Field -->
<div class="form-group">
    {!! Form::label('dna_file_path', 'Dna File Path:') !!}
    <p>{!! $customer->dna_file_path !!}</p>
</div>

<!-- Has Dna Field -->
<div class="form-group">
    {!! Form::label('has_dna', 'Has Dna:') !!}
    <p>{!! $customer->has_dna !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $customer->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $customer->updated_at !!}</p>
</div>

