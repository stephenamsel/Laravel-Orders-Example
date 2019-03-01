<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateorderRequest;
use App\Http\Requests\UpdateorderRequest;
use App\Repositories\orderRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\customer;
use App\Models\order;

class orderController extends AppBaseController
{
    /** @var  orderRepository */
    private $orderRepository;

    public function __construct(orderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }

    /**
     * Display a listing of the order.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->orderRepository->pushCriteria(new RequestCriteria($request));
        $orders = $this->orderRepository->all();

        return view('orders.index')
            ->with('orders', $orders);
    }

    /**
     * Show the form for creating a new order.
     *
     * @return Response
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created order in storage.
     *
     * @param CreateorderRequest $request
     *
     * @return Response
     */
    public function store(CreateorderRequest $request)
    {
        $input = $request->all();
		//Register on Stripe
		$stripeObj = $input['purchase'];
		\Stripe\Stripe::setApiKey("STRIPE-API-KEY");
		if(array_key_exists("coupon", $input)){
			$couponId = \Stripe\Coupon::retrieve($input["coupon"]).id;
		} else {
			$couponId = null;
		}
		$kitPrice = 2000;
		$customer = Customer::where('id', '=', $input["customer"])->first();
		if($stripeObj == 'subscription'){
			try{	
			\Stripe\Subscription::create([
			  "customer" => $customer->stripe_id,
			  "items" => [
			    [
			      "plan" => input['name'],
			      "coupon" => $couponId
			    ],
			  ]
			]);
			$orderType = "order";
			} catch (Exception $e) {
				Flash::alert($e->getMessage());
				return redirect()->back();
			}
		} else if($stripeObj == 'charge'){
			try{
				\Stripe\Charge::create([
				  "amount" => $kitPrice,
				  "currency" => "usd",
				  "description" => "Charge for kit for "
				], [
				  "idempotency_key" => "t8ilw0UzpyOxz28S",
				]);
				$orderType = "kit";
				$input['amount_paid'] = $kitPrice / 100.0;
			} catch (Exception $e){
				Flash::alert($e->getMessage());
				return redirect()->back();
			}
		}
		//No source specified for Charge because it is assumed that the default Card data has already been gathered
		//We need multi-use Sources (gathered separately from payment) to make repeated charges for Subscription.
		
		// I know redirect->back would send users to the 1st page rather than the checkout page.
		// With more time, I would edit the URL, 
		// following https://stackoverflow.com/questions/824349/how-to-modify-the-url-without-reloading-the-page
		// and set a route, apply the ajax-form JS to links, and manually trigger the document.load Event 
		// That would reproduce Turbolinks, but it seems a bit beyond the scope of the current Challenge.
		
		
		
		$order = $this->orderRepository->create($input);
		//Register on Shopify
		$sh = App::make('ShopifyAPI', [
			'API_KEY' => env('SHOPIFY_API_KEY'), 
			'API_SECRET' => env('SHOPIFY_API_SECRET'), 
			'SHOP_DOMAIN' => env('SHOPIFY_DOMAIN'), 
			'ACCESS_TOKEN' => env('SHOPIFY_TOKEN') //assuming we already have the token. We don't have a code to get a token.
		]);
		$setMetaField = [
			"METHOD" => "POST",
			"URL" => "/admin/customers/{$customer->shopify_id}/metafields.json",
			'DATA' => [
			    "namespace": "plans",
			    "key": "name",
			    "value": $input['name'],
			    "value_type": "string"
			]
		]
		$sh->call($setMetaField);
		
		if($customer->has_dna == false){
			$setMetaField = [
				"METHOD" => "POST",
				"URL" => "/admin/customers/{$customer->shopify_id}/metafields.json",
				'DATA' => [
				    "namespace": "stage",
				    "key": "waiting_dna",
				    "value": "",
				    "value_type": "string"
				]
			]
			
		}
		
		/*
		 * This is where I intended to put the Klaviyo API calls to send the Order Confirmation email.
		 * I see notes on their website about this being available out of the box.
		 * Some sources say it has to run through the Metrics API and others say the Profile API.
		 * I cannot find any reference to sending transactional emails in either API documentation-page.
		*/
		//Return view, responding to AJAX request
		$html = view('thank_you')->with('orderType', $orderType);
		$data = [
        	'elem' => ".content-container", 
        	'html' => $html
    	];
        return view('ajaxInsert')->with($data);
		
		
        
        //return view('thank_you')->with('orderType', $orderType) //redirect(route('orders.index'));
    }

    /**
     * Display the specified order.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        return view('orders.show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified order.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        return view('orders.edit')->with('order', $order);
    }

    /**
     * Update the specified order in storage.
     *
     * @param  int              $id
     * @param UpdateorderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateorderRequest $request)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        $order = $this->orderRepository->update($request->all(), $id);

        Flash::success('Order updated successfully.');

        return redirect(route('orders.index'));
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        $this->orderRepository->delete($id);

        Flash::success('Order deleted successfully.');

        return redirect(route('orders.index'));
    }
}
