<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $order->id !!}</p>
</div>

<!-- Customer Shopify Id Field -->
<div class="form-group">
    {!! Form::label('customer_shopify_id', 'Customer Shopify Id:') !!}
    <p>{!! $order->customer_shopify_id !!}</p>
</div>

<!-- Plan Name Field -->
<div class="form-group">
    {!! Form::label('plan_name', 'Plan Name:') !!}
    <p>{!! $order->plan_name !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $order->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $order->updated_at !!}</p>
</div>

