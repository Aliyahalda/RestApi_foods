<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods = Food::all();

        if($foods) {
            return ApiFormatter::createApi(200, 'succes', $foods);
        }else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createToken()
    {
        return csrf_token();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
            ]);

            // $foods = Food::create([
            //     'name' => $request->name,
            //     'description' => $request->description,
            //     'price' => $request->price,
            //     'image' => $request->image,
            // ]);


            $image = null;
            if($request->file){
                $extension = $request->file('file')->getClientOriginalExtension();
                $newName = $request->name.'-'.now()->timestamp.'.'.$extension;
                $request->file('file')->move(public_path('/storage/'), $newName);
            }
            $request['image'] = $newName;

            $create = Food::create($request->all());

              $data = Food::where('id', '=', $create->id)->get();

            if ($data) {
                return ApiFormatter::createApi(200, 'succes', $data);
            } else{
                return ApiFormatter::createApi(400, 'failed');

            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);

        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Food $food, $id)
    {
        try {
            $detail = Food::where('id', $id)->first();

            if ($detail) {
                return ApiFormatter::createApi(200, 'succes', $detail);
            } else{
                return ApiFormatter::createApi(400, 'failed');

            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required|min:8',
                'description' => 'required|min:3',
                'price' => 'required',

            ]);

            $food = Food::findOrFail($id);

            $food->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]);

            $updatefood = Food::where('id', $food->id);
            if ($updatefood) {
                return ApiFormatter::createApi(200, 'succes', $updatefood);
            } else{
                return ApiFormatter::createApi(400, 'failed');

            } 
        }
        catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food, $id)
    {
        try{
            $food = Food::findOrFail($id);
            $proses = $food->delete();

            if ($proses) {
                return ApiFormatter::createApi(200, 'succes', $proses);
            } else{
                return ApiFormatter::createApi(400, 'failed');

            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
     }

    // function generateRandomString($length = 10) {
    //     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //     $charactersLength = strlen($characters);
    //     $randomString = '';
    //     for ($i = 0; $i < $length; $i++) {
    //         $randomString .= $characters[random_int(0, $charactersLength - 1)];
    //     }
    //     return $randomString;
    // }
}