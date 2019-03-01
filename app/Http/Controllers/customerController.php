<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatecustomerRequest;
use App\Http\Requests\UpdatecustomerRequest;
use App\Repositories\customerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\customer;
use App\Models\order;


class customerController extends AppBaseController
{
    /** @var  customerRepository */
    private $customerRepository;

    public function __construct(customerRepository $customerRepo)
    {
        $this->customerRepository = $customerRepo;
    }

    /**
     * Display a listing of the customer.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->customerRepository->pushCriteria(new RequestCriteria($request));
        $customers = $this->customerRepository->all();

        return view('customers.index')
            ->with('customers', $customers);
    }

    /**
     * Show the form for creating a new customer.
     *
     * @return Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param CreatecustomerRequest $request
     *
     * @return Response
     */
    public function store(CreatecustomerRequest $request)
    {
        $input = $request->all();
		if(!(array_key_exists("has_dna", $input))) $input["has_dna"] = false;
		$input["shopify_id"] = "DUMMY ID";
		$input["stripe_id"] = "DUMMY ID";
		$input["dna_file_path"] = "";
				
		if(Customer::where('email', '=', $input["email"])->count() == 0){
			$customer = $this->customerRepository->create($input);
			Flash::success('Customer saved successfully.');
		} else {
			$customer = Customer::where('email', '=', $input["email"])->first();
			Flash::warning('Email Already Used');
		}
		
        
        $html = view('checkout')->with('customer', $customer);
		$data = [
        	'elem' => ".content-container", 
        	'html' => $html
    	];
        return view('ajaxInsert')->with($data);
    }

    /**
     * Display the specified customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        return view('customers.show')->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        return view('customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified customer in storage.
     *
     * @param  int              $id
     * @param UpdatecustomerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecustomerRequest $request)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        $customer = $this->customerRepository->update($request->all(), $id);

        Flash::success('Customer updated successfully.');

        return redirect(route('customers.index'));
    }

    /**
     * Remove the specified customer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        $this->customerRepository->delete($id);

        Flash::success('Customer deleted successfully.');

        return redirect(route('customers.index'));
    }
}
