<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(CustomerService $CustomerService)
    {
        return $CustomerService->customer();
    }
    

    public function edit(Request $request, CustomerService $CustomerService)
    {
        return $CustomerService->customerdetail($request->id);
    }

    public function update(Request $request, CustomerService $CustomerService)
    {
        return $CustomerService->customerupdate($request);
    }

    public function store(Request $request, CustomerService $CustomerService)
    {
        return $CustomerService->store($request);

    }

    public function destroy(Request $request, CustomerService $CustomerService)
    {
        return $CustomerService->destroy($request->id);
    }
}
