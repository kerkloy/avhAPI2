<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return response()->json($product);
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
        $product = Product::find($id);

        $data['brand'] = DB::select('SELECT DISTINCT(supBrand) FROM suppliers');
        $data['type'] = DB::select('SELECT DISTINCT(supBrdType) FROM suppliers');

        return response()->json($product);
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
        try{
            $validatedData = $request->validate([
                'prodName' => 'required',
                'prodType' => 'required',
                'prodBrand' => 'required',
                'prodSPrice' => 'required|numeric',
                'prodQty' => 'required|integer|min:1'
            ]);
            $product = Product::find($id);
            
            if (!$product) {
                return response()->json(['error' => 'Order not found'], 404);
            }
            $product->update([
                'prodName' => $validatedData['prodName'],
                'prodType' => $validatedData['prodType'],
                'prodBrand' => $validatedData['prodBrand'],
                'prodSPrice' => $validatedData['prodSPrice'],
                'prodQty' => $validatedData['prodQty']
            ]);
            return response()->json(['success' => 'Product updated successfully']);
           }catch(\Exception $e){
    
            return response()->json(['success' => $e->getMessage()]);
    
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
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }
        $product->delete();
        return response()->json(['success' => 'Product successfully deleted!']);
    }
}
