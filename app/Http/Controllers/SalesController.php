<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        return response([
            'sales' => Sale::orderBy('id','asc')->get(),
        ], 200);
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributs= $request->validate([
            "customer_id"=>"required",
            "good_id"=>"required",
            "good_quantity"=>"required",
        ]);
        $good=Good::find($request->good_id);
        //update good
        if(($good->good_quantity-$attributs['good_quantity'])>=0){
            $good->good_quantity=$good->good_quantity-$attributs['good_quantity'];

            $good->save();
        }
        else{
            return response([
                'message' =>"good finished.",
            ],403);
        }
        $sale = Sale::create([
            'seller_id'=>auth()->user()->id,
            'customer_id'=>$attributs['customer_id'],
            'good_id'=>$attributs['good_id'],
            'good_quantity'=> $attributs['good_quantity'],
            'good_unit_price'=>$good->good_unit_price,
            'total'=>$good->good_unit_price*$attributs['good_quantity'],
        ]);
      
        return response([
            'message' =>"sale saved.",
            'sale'=>$sale
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response([
            'sale' =>Sale::find($id),
        ],200);
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $attributs=$request->validate([
            "customer_id"=>"required",
            "good_quantity"=>"required",
        ]);
        
        $sale= Sale::find($id);
        if(!$sale){
            return response([
                'messsage'=>'sale not found.'
            ],403);
        }
        $good=Good::find($sale->good_id);
        //on rajoute aux nombre du produi la quantite retranche au paravant
            $good->good_quantity=$good->good_quantity+$sale->good_quantity;

            $good->save();
        //update good
        if(($good->good_quantity-$attributs['good_quantity'])>=0){
            $good->good_quantity=$good->good_quantity-$attributs['good_quantity'];

            $good->save();
        }
        
        
    
        $sale->customer_id=$request->customer_id;
        $sale->good_quantity=$request->good_quantity;
        $sale->total=$sale->good_unit_price*$sale->good_quantity;
        $sale->save();
        return response([
            'message' =>"sale updated.",
            'sale'=>$sale
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        $sale= Sale::find($id);
        if(!$sale){
            return response([
                'messsage'=>'sale not found.'
            ],403);
        }
        $good=Good::find($sale->good_id);
        if($good){
            $good->good_quantity=$good->good_quantity+$sale->good_quantity;
            $good->save();
        }

        
        
        $sale->delete();
        return response([
            'message' =>"sale deleted.",
        ],200);
    }
    function search($good_id){
        $name=Good::find($good_id)->good_name;
        return Sale::where("good_id","like","%".$name."%")->get();
    }
}
