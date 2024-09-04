<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::all();

        return response()->json($sales);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = DB::table('products')
        ->where('id',$id)
        ->first();

   

        $data['type'] = DB::select('SELECT DISTINCT(supBrdType) FROM suppliers');
        $data['name'] = DB::select('SELECT DISTINCT(custName) FROM customers');
       

        return response()->json($response);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['error' => 'Product not found.'], 404);
        }
        $sale->delete();
        return response()->json(['success' => 'Product successfully deleted!']);
    }

    public function getSaleData($id){
        try {
            $sale = Sale::findOrFail($id);

            return response()->json(['sale' => $sale]);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error fetching sale data'], 500);
        }
    }
}
