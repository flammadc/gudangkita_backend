<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class OutcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return Outcome::orderBy("created_at", "desc")->get();
        } catch (\Throwable $th) {
            return response("Something Went Wrong", 500);
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
        $product->stock += $request->quantity;
        $product->update();
        
        return Outcome::create([
            "product_id" => $request['product_id'],
            "price" => $request['price'],
            "quantity" => $request['quantity'],
            "amount" => $request['amount'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Out  $out
     * @return \Illuminate\Http\Response
     */
    public function show(Out $out)
    {
        try {
            return Outcome::find($id);
        } catch (\Throwable $th) {
            return response("Something Went Wrong", 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Out  $out
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Out $out)
    {
        try {
            $data = Outcome::find($id);
            $data->name = $request->name;
            $data->supplier = $request->supplier;
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
     * @param  \App\Models\Out  $out
     * @return \Illuminate\Http\Response
     */
    public function destroy(Out $out)
    {
        try {
            Outcome::destroy($id);
        } catch (\Throwable $th) {
            return response("Something Went Wrong", 500);
        }        
        return response("Product has been Deleted", 200);
    }

    /**
     * Display stats of Income this year.
     *
     * @return \Illuminate\Http\Response
     */
    public function stats()
    {
        try {
            $outcome = Outcome::whereYear("created_at", date("Y"))
            ->selectRaw('month(created_at) month, sum(amount) amount')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        } catch (\Throwable $th) {
            return response($th, 500);
        }

        return response($outcome, 200);
    }

    /**
     * Display Total amount of Outcome this year.
     *
     * @return \Illuminate\Http\Response
     */
    public function total(){
        try {
            $outcome = Outcome::whereYear("created_at", date("Y"))
            ->selectRaw('sum(amount) amount')
            ->get();
        } catch (\Throwable $th) {
            return response($th, 500);
        }

        return response($outcome, 200);
    }
}
