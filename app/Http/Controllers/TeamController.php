<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return User::all();
        } catch (\Throwable $th) {
            return response("Something Went Wrong", 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return User::find($id);
        } catch (\Throwable $th) {
            return response($th, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = User::find($id);
            $path = $request->file('profile') ?  $request->file("profile")->store("profiles", ['disk' => 'public']) : $data->profile;
            $password = $request->password ? bcrypt($request->password) : $data->password;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->profile = $path;
            $data->password = $password;
            $data->update();
        } catch (\Illuminate\Database\QueryException $ex) {
            return response($ex, 500);
        }

        return response($data, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return User::destroy($id);
        } catch (\Throwable $th) {
            return response("Something Went Wrong",500);
        }
    }
}
