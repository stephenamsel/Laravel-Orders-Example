<table class="table table-responsive" id="customers-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Email</th>
        <th>Shopify Id</th>
        <th>Stripe Id</th>
        <th>Dna File Path</th>
        <th>Has Dna</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($customers as $customer)
        <tr>
            <td>{!! $customer->name !!}</td>
            <td>{!! $customer->email !!}</td>
            <td>{!! $customer->shopify_id !!}</td>
            <td>{!! $customer->stripe_id !!}</td>
            <td>{!! $customer->dna_file_path !!}</td>
            <td>{!! $customer->has_dna !!}</td>
            <td>
                {!! Form::open(['route' => ['customers.destroy', $customer->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('customers.show', [$customer->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('customers.edit', [$customer->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>