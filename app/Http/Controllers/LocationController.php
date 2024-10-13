<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           $request->validate([
              'street' => 'required|max:255',
              'building' => 'required|max:255',
              'area' => 'required|max:255',

           ]);

           Location::create([
               'street'=>$request->street,
               'building'=>$request->building,
               'area'=>$request->area,
               'user_id'=>Auth::id(),
           ]);
           return response()->json(['location added successfully.'],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'street' => 'required|max:255',
            'building' => 'required|max:255',
            'area' => 'required|max:255',

        ]);
        $location =Location::find($id);
        if($location){
            $location->street=$request->street;
            $location->building=$request->building;
            $location->area=$request->area;
            $location->save();
            return response()->json([
                'message'=>'location updated successfully.',
                'data' =>$location,
            ],200);
        }else{
            return response()->json([
                'message'=>'location not found.',
            ],404);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location=Location::find($id);
        if(!$location){
            return response()->json([
                'message'=>'location not found'
            ],404);

        }else{
            $location->delete();
            return response()->json([
                'message'=>'location deleted successfully.'
            ],200);
        }
    }
}
