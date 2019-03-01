:php
  
  if($customer->has_dna == 1){
  	$pars = ['purchase' => 'subscription', 'coupon' => 'TEST', 'name' => 'standard', 'customer' => $customer->id];
  } else {
  	$pars = ['purchase' => 'charge', 'name' => 'kit', 'customer' => $customer->id];
  }
.container
  %h3 Confirm Order
  - if( $customer->has_dna)
    %p
      You noted that you already have your DNA information.
      You may now subscribe to our regular service where
      using that information, we can send you customized products.
      Click below to confirm that you would like to purchase a
      subscription to receive our products.
    %button.btn.btn-success{onclick: "$.get({ route('orders.store', $pars) });"}
      Purchase a Subscription
  - else
    %p
      You indicated that you have not had your DNA sequenced.
      We must sequence it in order to customize products for you.
      Click below to confirm that you would like to purchase a
      kit to collect DNA for sequencing.
    %button.btn.btn-success{onclick: "$.get({ route('orders.store', $pars) });"}
      Purchase a Kit
