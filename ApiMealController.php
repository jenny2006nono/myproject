<?php

namespace App\Http\Controllers\api;

use App\Meals;
use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MealsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function query(Request $request,Meals $meals)
    {
        //
        if(isset($request->meals_id)) {
            //所選餐點
            $mealsType = Meals::where('meals_online',1)
            ->where('meals_id', $request->meals_id)
                        ->get();
        }
        else if(isset($request->meals_type_id)){
            //分店所選類別餐點
            $mealsType = Meals::where('meals_online',1)
            ->where('branch_id', $request->branch_id)
                        ->where('meals_type_id',$request->meals_type_id)
                        ->orWhere('meals_type_id',0)
                        ->get();
        } 
        else{
            //分店所有餐點
            $mealsType = Meals::where('meals_online',1)
            ->where('branch_id', $request->branch_id)
            ->orWhere('meals_type_id',0)
                        ->get();
        }
        

        $data = ['data' => $mealsType];
        return response()->json($data);

    }
}
