<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return Income::all();
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
            "product_id" => "required|integer",
            "price" => "required|string",
            "quantity" => "required|integer",
            "amount" => "required|string",
        ]);

        if($validated->fails()){
            return $this-sendError($validated->errors());
        }
        
        $product = Product::find($request->product_id);
        $product->stock -= $request->quantity;
        $product->update();
        
        return Income::create([
            "product_id" => $request['product_id'],
            "price" => $request['price'],
            "quantity" => $request['quantity'],
            "amount" => $request['amount'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            return Income::find($id);
        } catch (\Throwable $th) {
            return response("Something Went Wrong", 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        try {
            $data = Income::find($id);
            $data->name = $request->name;
            $data->price = $request->price;
            $data->quantity = $request->quantity;
            $data->amount = $request->amount;
            $data->update();
        } catch (\Illuminate\Database\QueryException $ex){ 
            return $this->sendError('Something Went Wrong', null);
        }
        return response($data, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        try {
            Income::destroy($id);
        } catch (\Throwable $th) {
            return response("Something Went Wrong", 500);
        }
        
        return response("Product has been Deleted", 200);
    }
}
