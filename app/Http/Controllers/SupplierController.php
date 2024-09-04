<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::all();

        return response()->json(array('supplier' => $supplier));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
        $supplier = $request->validate([
            'supName' =>'required',
            'supBrand' =>'required',
            'supBrdType' =>'required',
            'supAdr' =>'required',
            'supCon' =>'required',
        ]);

        $newSupplier = Supplier::create($supplier);

        if(!$newSupplier) {
            return response()->json(array('message' => 'Supplier could not be created.'));
        }
        else {
            return response()->json(array('message' => 'Supplier created successfully.'));
        }

        }   
        catch (Exception $e) { 
            return response()->json(array('message' => $e->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
        $response = Supplier::find($id);

        return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(array('message' => $e->getMessage()));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
        $validatedData = $request ->validate([
            'supName' =>'required',
           'supBrand' =>'required',
           'supBrdType' =>'required',
           'supAdr' =>'required',
           'supCon' =>'required',
        ]);

        $supplier = Supplier::find($id);

        if(!$supplier){
            return response()->json(array('message' => 'Supplier not found'));
        } else {
            $supplier->update([
               'supName' => $validatedData['supName'],
               'supBrand' => $validatedData['supBrand'],
               'supBrdType' => $validatedData['supBrdType'],
               'supAdr' => $validatedData['supAdr'],
               'supCon' => $validatedData['supCon'],
            ]);
            return response()->json(array('message' => 'Supplier updated successfully'));
        }
        } catch (\Exception $e) {
            return response()->json(array('message' => $e->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        if(!$supplier){
            return response()->json(array('message' => 'Supplier not found'));
        } else {
            $supplier->delete();

            return response()->json(array('message' => 'Supplier deleted successfully'));
        }
    }
}
