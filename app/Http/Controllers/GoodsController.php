<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Good;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response([
            'goods' => Good::orderBy('id','asc')->where('good_quantity',">","0")->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * public function store(Request $request)

     */
    
    public function store(Request $request)
    {
     $request->validate
       ([
        "image"=>"required",
            "good_name"=>"required|string",
            "good_description"=>"required|string",
            "good_quantity"=>"required",
            "good_unit_price"=>"required",
    ]);
    $good = new Good();
    $good->image=$request->input('image');
    $good->good_name = $request->input('good_name');
    $good->good_description = $request->input('good_description');
    $good->good_quantity = $request->input('good_quantity');
    $good->good_unit_price = $request->input('good_unit_price');
    $good->save();
       
     return response([
        'message' =>"good saved.",
        'good'=>$good
    ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response([
            'good' =>Good::find($id),
        ],200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $good = Good::findOrFail($id);
        if(!$good){
            return response([
                'messsage'=>'Good not found.'
            ],403);
        }
        
    $good->good_name = $request->input('good_name');
    $good->good_description = $request->input('good_description');
    $good->good_quantity = $request->input('good_quantity');
    $good->good_unit_price = $request->input('good_unit_price');
    // if ($request->hasFile('good_image')) {
    //     Storage::delete($good->good_image);
    //     $good->good_image = $request->file('good_image')->store('public/images');
    // }
    $good->save();
          return response([
            'message' =>"good updated.",
            'good'=>$good
        ],200);
           
          
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $good = Good::findOrFail($id);
        if(!$good){
            return response([
                'messsage'=>'Good not found.'
            ],403);
        }
        $good->delete();
       
  //  Storage::delete($good->good_image);
    $good->delete();
    return response([
        'message' =>"Good deleted.",
    ],200);
    }
    function search($name){
        return response([
            'good' => Good::where("good_name","like","%".$name."%")->get(),
        ], 200);
    }
     
}
