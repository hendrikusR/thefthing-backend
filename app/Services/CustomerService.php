<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Http\Response;
use Illuminate\Validation\Validator;


class CustomerService {

    public function customer()
    {

        $data = [];
        $customers = Customer::all();

        foreach($customers as $customer) {
            $data[] = [
                'customer_id' => $customer['customer_id'],
                'name' => $customer['name'],
                'email' => $customer['email'],
                'gender' => $customer['gender'] == 1 ? 'Laki-Laki' : 'Perempuan',
                'is_married' => $customer['is_married'] == 1 ? 'Married' : 'Single',
                'address' => $customer['address']
            ];
        }



        return response()->json([
            'status' => [
                'code' => 200,
                'response' => 'Success',
                'message' => $customers->isNotEmpty() ? 'Data is available' : 'Data is not available'
            ],
            'result' => [
                'data' => $data
            ]
        ],200);        
    }

    public function customerdetail($id)
    {
        $data = [];
        $customer = Customer::find($id);

        return response()->json([
            'status' => [
                'code' => 200,
                'response' => 'Success',
                'message' => !empty($customer) ? 'Data is available' : 'Data not available'
            ],
            'result' => [
                'data' => $customer
            ]
        ],200);   
    }

    public function customerupdate($request)
    {

        try {


            if(!empty($this->findById($request->id))) {

                $customer_id = $request->id;
                $request = $request->all();
                
                $validator = \Validator::make($request, [
                    'name' => 'required',
                    'email' => 'required|email|unique:customers,email,'.$customer_id.',customer_id',
                    'gender' => 'required',
                    'is_married' => 'required',
                    'address' => 'required'
                ]);

                if($validator->fails()) {
                    return response()->json([
                        'status' => [
                            'code' => 422,
                            'response' => 'Failed',
                            'message' => 'Your Data can\'t be Created'
                        ],
                        'result' => $validator->errors()
                    ],422);
                } 

                if(!empty($request['password'])) {
                    $request['password'] = app('hash')->make($request['password']);
                }

                Customer::where('customer_id', $customer_id)->update($request);

                return response()->json([
                    'status' => [
                        'code' => 200,
                        'response' => 'Success',
                        'message' => 'Your Data Has Been Updated'
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => [
                        'code' => 404,
                        'response' => 'Failed',
                        'message' => 'Data not available'
                    ]
                ], 404);
            }
            
        } catch (\Throwable $th) {
            echo $th;
        } 

    }

    public function store($request)
    {

        try {

            $request = $request->all();
            $validator = \Validator::make($request, [
                'name' => 'required',
                'email' => 'required|email|unique:customers',
                'password' => 'required',
                'gender' => 'required',
                'is_married' => 'required',
                'address' => 'required'
            ]);

            if($validator->fails()) {
                return response()->json([
                    'status' => [
                        'code' => 422,
                        'response' => 'Failed',
                        'message' => 'Your Data can\'t be Created'
                    ],
                    'result' => $validator->errors()
                ],422);
            } 

            $request['password'] = app('hash')->make($request['password']);


            Customer::create($request);
            
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => 'Success',
                    'message' => 'Your Data Has Been Created'
                ]
            ], 200);
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function destroy($id)
    {
        try {
            Customer::find($id)->delete();
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => 'Success',
                    'message' => 'Your Data Has Been Deleted'
                ]
            ], 200);    
        } catch (\Throwable $th) {
            echo $th;
        }
        
    }

    public function findById($id)
    {
        return Customer::find($id);
    }
}