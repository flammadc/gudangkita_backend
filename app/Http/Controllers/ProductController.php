<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return Product::all();
        } catch (\Throwable $th) {
            return response("Something went wrong", 500);
        }
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "name" => "required",
            "category_id" => "required|integer",
            "category_id" => "required|integer",
            "category_id" => "required"
        ]);
        
        if($validated->fails()){
            return $this-sendError($validated->errors());
        }
        
        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Product::find($id);
        } catch (\Throwable $th) {
            return response("Something Went Wrong", 500);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Product::find($id);
            $data->name = $request->name;
            $data->stock = $request->stock;
            $data->price = $request->price;
            $data->update();
        } catch (\Illuminate\Database\QueryException $ex){ 
            return $this->sendError('Something Went Wrong', null);
        }
        return response($data, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        try {
            !Product::destroy($id);
        } catch (\Throwable $th) {

            return response("Something Went Wrong", 500);
        }
        
        return response("Product has been Deleted", 200);
    }
}