<?php
//編輯餐點頁面
    public function Edit($id){


        $meals_data = \DB::table('meals')
                            ->leftjoin('branch','branch.branch_id','meals.branch_id')
                            ->leftjoin('meals_type','meals_type.meals_type_id','meals.meals_type_id')
                            ->select('meals.*','branch.branch_name','meals_type.*')
                            ->where('meals.id','=',$id)
                            ->get();

        $meals_info = json_decode(json_encode($meals_data),true);
        $branch_id = $meals_info[0]['branch_id'];


        $branch = \DB::table('branch')->get();

        $meals_type = \DB::table('meals_type')
                        ->where('branch_id',$branch_id)
                        ->get();
        return view('Meals/meals_Edit',['meals_data' => $meals_data,'branch'=>$branch,'meals_type'=>$meals_type])->with($id);
        

    }

    //編輯餐點
    public function Update(Request $request,$id){

        $meals_update = $request->all();
        $meals_data = \DB::table('meals')
                        ->where('meals_id','=',$id)
                        ->get();
        $meals_info = json_decode(json_encode($meals_data),true);
        $data=array();

        $insert_field = ['meals_id', 'branch_id', 'meals_type_id', 'meals_name', 'meals_price', 'isSetMeal', 'isThreeHalfprice', 'threeHalfprice', 'isusepoints', 'meals_online'];
        $new = array();
        foreach ($insert_field as $key2 => $field) {
            foreach ($meals_update as $key => $value) {
                if ($key == $field) {
                    $data[$key]=$value;
                }
            }

        }
        $data['meals_id']=$meals_info[0]['meals_id'];
        $data['meals_online'] = '1';
        $id = \DB::table('meals')->where('meals_id',$data['meals_id'])->update($data);

        return redirect('meals')->with('success', '異動成功');

    }
 ?>
