<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Employee;
use App\Models\Medicine;
use App\Models\Region;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $action = Action::all();
        $region = Region::all();
        $medicine = Medicine::all();
        if ($request->ajax()) {
            $data = User::latest()->get();    
            return DataTables()->of($data)
                ->addColumn('actions', function ($data){
                    $id = $data->id;
                    $button = '<button type="button" data-toggle="tooltip"  id="' . $id . '" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post mb-1"><i class="bx bxs-edit-alt"></i></button>';
                    $button .='<button type="button" data-toggle="tooltip"  id="' . $id . '" data-original-title="Delete" class="delete btn btn-info btn-sm delete-post mb-1"><i class="bx bx-trash"></i></button>';
                    $button .='<button type="button" data-toggle="tooltip"  id="' . $id . '" data-original-title="Delete" class="status btn btn-info btn-sm delete-post mb-1"><i class="bx bxs-dollar-circle"></i></button>';

                    return $button;
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.dashboard', ["action" => $action, "region" => $region, "medicine" => $medicine]);
    }

    public function storePasien(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2| max:30',
            'identity' => 'numeric|min:16|digits:16',
        ]);

        
        if (!$validator->fails()) 
        {
            $action = Action::find($request->action);
            $medicine = Medicine::find($request->medicine);
            $region = Region::find($request->region);
    
            $totalPrice = (int) $medicine->price + (int) $action->price;
    
            $input = array(
                "name" => $request->name,
                "password" => bcrypt("12345678"),
                "identity" => $request->identity,
                "action" => $action->name,
                "region" => $region->name,
                "medicine" => $medicine->name,
                "total_price" => $totalPrice
            );

            try {
                $data = User::create($input);
                return response()->json( ['data' => $data, 'text' => "Data Tersimpan", 200]);
            } catch (Exception $e) {
                return response()->json( ['text' => $e->getMessage() , 400]);
            }
        }
        else
        {
            return response()->json(['status' => 0, 'error'=>$validator->errors()->toArray()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPasien(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePasien(Request $request)
    {
        $id = $request->id;
        $action = Action::find($request->action);
        $medicine = Medicine::find($request->medicine);
        $region = Region::find($request->region);

        $input = array(
            "name" => $request->name,
            "password" => bcrypt("12345678"),
            "identity" => $request->identity,
        );
        
        if ($region != null) {
            $input["region"] = $region->name;
        }

        if ($action != null) {
            $actionPrice =  (int) $action->price;
            $input["action"] = $action->name;
        }else{
            $actionPrice = 0;
        }

        if ($medicine != null) {
            $medicinePrice = (int) $medicine->price ;
            $input["medicine"] = $medicine->name ;
        }
        else{
            $medicinePrice = 0;
        }

        if ($action != null || $medicine != null) {
            $totalPrice = $medicinePrice + $actionPrice;
            $input["total_price"] = $totalPrice;
        }
        try {
            DB::table('users')->where('id', $id)->update($input);

            return response()->json(['text' => "Data Berhasil Di Update"], 200);
            
        } catch (Exception $e) {
            return response()->json(['text' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPasien(Request $request)
    {  
        $id = $request->id;
        try {
            DB::table('users')->where('id', $id)->delete();
            return response()->json(['text' => "Data Berhasil Di Delete"], 200);
        } catch (Exception $e) {
            return response()->json(['text' => $e->getMessage()], 404);
        }   
    }

    /**
     * Update Status the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statusPasien(Request $request)
    {  
        $id = $request->id;
        try {
            DB::table('users')->where('id', $id)->update(["status" => "LUNAS"]);

            return response()->json(['text' => "Data Berhasil Di Update"], 200);
            
        } catch (Exception $e) {
            return response()->json(['text' => $e->getMessage()]);
        }   
    }

    // --------------------------------------------------------------------------------------------------------------------
    // Obat
    public function medicine(Request $request)
    {
        if ($request->ajax()) {
            $data = Medicine::latest()->get();    
            return DataTables()->of($data)
                ->addColumn('actions', function ($data){
                    $id = $data->id;
                    $button = '<button type="button" data-toggle="tooltip"  id="' . $id . '" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post mb-1"><i class="bx bxs-edit-alt"></i></button>';
                    $button .='<button type="button" data-toggle="tooltip"  id="' . $id . '" data-original-title="Delete" class="delete btn btn-info btn-sm delete-post mb-1"><i class="bx bx-trash"></i></button>';

                    return $button;
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.medicine');
    }

    public function storeMedicine(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
        ]);
        if (!$validator->fails()) 
        {
            try {
                $data = Medicine::create($request->all());
                return response()->json( ['data' => $data, 'text' => "Data Tersimpan", 200]);
            } catch (Exception $e) {
                return response()->json( ['text' => $e->getMessage() , 400]);
            }
        }
        else
        {
            return response()->json(['status' => 0, 'error'=>$validator->errors()->toArray()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editMedicine(Request $request)
    {
        $id = $request->id;
        $data = Medicine::find($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMedicine(Request $request)
    {
        $id = $request->id;
        try {
            DB::table('medicines')->where('id', $id)->update($request->except('_token'));

            return response()->json(['text' => "Data Berhasil Di Update"], 200);
            
        } catch (Exception $e) {
            return response()->json(['text' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyMedicine(Request $request)
    {  
        $id = $request->id;
        try {
            DB::table('medicines')->where('id', $id)->delete();
            return response()->json(['text' => "Data Berhasil Di Delete"], 200);
        } catch (Exception $e) {
            return response()->json(['text' => $e->getMessage()], 404);
        }   
    }


    // ------------------------------------------------------------------------------------------------------------
    // Tindakan
    public function action(Request $request)
    {
        if ($request->ajax()) {
            $data = Action::latest()->get();    
            return DataTables()->of($data)
                ->addColumn('actions', function ($data){
                    $id = $data->id;
                    $button = '<button type="button" data-toggle="tooltip"  id="' . $id . '" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post mb-1"><i class="bx bxs-edit-alt"></i></button>';
                    $button .='<button type="button" data-toggle="tooltip"  id="' . $id . '" data-original-title="Delete" class="delete btn btn-info btn-sm delete-post mb-1"><i class="bx bx-trash"></i></button>';

                    return $button;
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.action');
    }

    public function storeAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
        ]);
        if (!$validator->fails()) 
        {
            try {
                $data = Action::create($request->all());
                return response()->json( ['data' => $data, 'text' => "Data Tersimpan", 200]);
            } catch (Exception $e) {
                return response()->json( ['text' => $e->getMessage() , 400]);
            }
        }
        else
        {
            return response()->json(['status' => 0, 'error'=>$validator->errors()->toArray()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAction(Request $request)
    {
        $id = $request->id;
        $data = Action::find($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAction(Request $request)
    {
        $id = $request->id;
        try {
            DB::table('actions')->where('id', $id)->update($request->except('_token'));

            return response()->json(['text' => "Data Berhasil Di Update"], 200);
            
        } catch (Exception $e) {
            return response()->json(['text' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAction(Request $request)
    {  
        $id = $request->id;
        try {
            DB::table('actions')->where('id', $id)->delete();
            return response()->json(['text' => "Data Berhasil Di Delete"], 200);
        } catch (Exception $e) {
            return response()->json(['text' => $e->getMessage()], 404);
        }   
    }


    // ------------------------------------------------------------------------------------------------------------
    // Employee
    public function employee(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::latest()->get();    
            return DataTables()->of($data)
                ->addColumn('actions', function ($data){
                    $id = $data->id;
                    $button = '<button type="button" data-toggle="tooltip"  id="' . $id . '" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post mb-1"><i class="bx bxs-edit-alt"></i></button>';
                    $button .='<button type="button" data-toggle="tooltip"  id="' . $id . '" data-original-title="Delete" class="delete btn btn-info btn-sm delete-post mb-1"><i class="bx bx-trash"></i></button>';

                    return $button;
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.employee');
    }

    public function storeEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'jabatan' => 'required',
        ]);
        if (!$validator->fails()) 
        {
            try {
                $data = Employee::create($request->all());
                return response()->json( ['data' => $data, 'text' => "Data Tersimpan", 200]);
            } catch (Exception $e) {
                return response()->json( ['text' => $e->getMessage() , 400]);
            }
        }
        else
        {
            return response()->json(['status' => 0, 'error'=>$validator->errors()->toArray()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editEmployee(Request $request)
    {
        $id = $request->id;
        $data = Employee::find($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmployee(Request $request)
    {
        $id = $request->id;
        try {
            DB::table('employees')->where('id', $id)->update($request->except('_token'));

            return response()->json(['text' => "Data Berhasil Di Update"], 200);
            
        } catch (Exception $e) {
            return response()->json(['text' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyEmployee(Request $request)
    {  
        $id = $request->id;
        try {
            DB::table('employees')->where('id', $id)->delete();
            return response()->json(['text' => "Data Berhasil Di Delete"], 200);
        } catch (Exception $e) {
            return response()->json(['text' => $e->getMessage()], 404);
        }   
    }


    // ------------------------------------------------------------------------------------------------------------
    // Wilayah
    public function region(Request $request)
    {
        if ($request->ajax()) {
            $data = Region::latest()->get();    
            return DataTables()->of($data)
                ->addColumn('actions', function ($data){
                    $id = $data->id;
                    $button = '<button type="button" data-toggle="tooltip"  id="' . $id . '" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post mb-1"><i class="bx bxs-edit-alt"></i></button>';
                    $button .='<button type="button" data-toggle="tooltip"  id="' . $id . '" data-original-title="Delete" class="delete btn btn-info btn-sm delete-post mb-1"><i class="bx bx-trash"></i></button>';

                    return $button;
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.region');
    }

    public function storeRegion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
        ]);
        if (!$validator->fails()) 
        {
            try {
                $data = Region::create($request->all());
                return response()->json( ['data' => $data, 'text' => "Data Tersimpan", 200]);
            } catch (Exception $e) {
                return response()->json( ['text' => $e->getMessage() , 400]);
            }
        }
        else
        {
            return response()->json(['status' => 0, 'error'=>$validator->errors()->toArray()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editRegion(Request $request)
    {
        $id = $request->id;
        $data = Region::find($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRegion(Request $request)
    {
        $id = $request->id;
        try {
            DB::table('regions')->where('id', $id)->update($request->except('_token'));

            return response()->json(['text' => "Data Berhasil Di Update"], 200);
            
        } catch (Exception $e) {
            return response()->json(['text' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRegion(Request $request)
    {  
        $id = $request->id;
        try {
            DB::table('regions')->where('id', $id)->delete();
            return response()->json(['text' => "Data Berhasil Di Delete"], 200);
        } catch (Exception $e) {
            return response()->json(['text' => $e->getMessage()], 404);
        }   
    }
}
