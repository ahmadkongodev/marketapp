<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return response([
            'customers' => Customer::orderBy('id','asc')->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributs = $request->validate([
            'customer_firstname'=> "required|string",
            'customer_lastname'=> "required|string",
            'customer_phone'=> "required",
        ]);
        $customer = Customer::create([
            'customer_firstname'=>$attributs['customer_firstname'],
            'customer_lastname'=>$attributs['customer_lastname'],
            'customer_phone'=> $attributs['customer_phone'],
        ]);
        return response([
            'message' =>"customer saved.",
            'customer'=>$customer
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer= Customer::find($id);
        if(!$customer){
            return response([
                'messsage'=>'Customer not found.'
            ],403);
        }
        else{
        return response([
            'customer' =>Customer::find($id),
        ],200);
    }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $customer= Customer::find($id);
        if(!$customer){
            return response([
                'messsage'=>'Customer not found.'
            ],403);
        }
        $attributs = $request->validate([
            'customer_firstname'=> "required|string",
            'customer_lastname'=> "required|string",
            'customer_phone'=> "required",
        ]);
        $customer->update([
            'customer_firstname'=>$attributs['customer_firstname'],
            'customer_lastname'=>$attributs['customer_lastname'],
            'customer_phone'=> $attributs['customer_phone'],
        ]);
        return response([
            'message' =>"customer updated.",
            'customer'=>$customer
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer= Customer::find($id);
        if(!$customer){
            return response([
                'messsage'=>'Customer not found.'
            ],403);
        }
        $customer->delete();
        return response([
            'message' =>"customer deleted.",
        ],200);
    }
    function search($name){
        return response([
            'customers' => Customer::where("customer_firstname","like","%".$name."%")->get(),
        ], 200);
    }
}
