<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();

        return response()->json(array('orders' => $orders));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            // Fetch distinct product types and brands using raw SQL
            $prodTypes = DB::select('SELECT DISTINCT supBrdType FROM suppliers');
            $prodBrands = DB::select('SELECT DISTINCT supBrand FROM suppliers');

            // Convert the result sets into arrays
            $prodTypesArray = array_map(function($item) { return $item->supBrdType; }, $prodTypes);
            $prodBrandsArray = array_map(function($item) { return $item->supBrand; }, $prodBrands);
        
            // Return the data as a JSON response
            return response()->json([
                'prodTypes' => $prodTypesArray,
                'prodBrands' => $prodBrandsArray,
            ]);
        } catch (\Exception $e) {
            // Log any exceptions for debugging
            Log::error('Error fetching data:', ['error' => $e->getMessage()]);
    
            // Return an error response
            return response()->json([
                'message' => 'Error fetching data',
            ], 500);
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
        try {
            $orderData = $request -> validate([
                'prodName' => 'required',
                'prodType' => 'required',
                'prodBrand' => 'required',
                'ordQty' => 'required|integer|min:1',
                'prodOPrice' => 'required|numeric',
                'prodSPrice' => 'required|numeric',
                'totalOrderPrice' => 'required|numeric',
                'ordDate' => 'required'
            ]);
            $newOrder = Order::create($orderData);
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
        $order = Order::find($id);

        $data['brand'] = DB::select('SELECT DISTINCT(supBrand) FROM suppliers');
        $data['type'] = DB::select('SELECT DISTINCT(supBrdType) FROM suppliers');

        return response()->json($order);
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
                'ordQty' => 'required|integer|min:1',
                'prodOPrice' => 'required|numeric',
                'prodSPrice' => 'required|numeric',
                'totalOrderPrice' => 'required|numeric',
                'ordDate' => 'required'
            ]);
            $order = Order::find($id);
            
            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }
            $order->update([
                'prodName' => $validatedData['prodName'],
                'prodType' => $validatedData['prodType'],
                'prodBrand' => $validatedData['prodBrand'],
                'ordQty' => $validatedData['ordQty'],
                'prodOPrice' => $validatedData['prodOPrice'],
                'prodSPrice' => $validatedData['prodSPrice'],
                'totalOrderPrice' => $validatedData['totalOrderPrice'],
                'ordDate' => $validatedData['ordDate']
            ]);
            return response()->json(['success' => 'Order updated successfully']);
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
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }
        $order->delete();
        return response()->json(['success' => 'Order successfully deleted!']);
    }

    public function getBrand() {
        // $brand = DB::select('SELECT supBrand, supBrdType FROM suppliers');

        $prodTypes = DB::select('SELECT DISTINCT supBrdType FROM suppliers');
        $prodBrands = DB::select('SELECT DISTINCT supBrand FROM suppliers');

        // Convert the result sets into arrays
        $prodTypesArray = array_map(function($item) { return $item->supBrdType; }, $prodTypes);
        $prodBrandsArray = array_map(function($item) { return $item->supBrand; }, $prodBrands);
    
        // Return the data as a JSON response
        return response()->json([
            'prodTypes' => $prodTypesArray,
            'prodBrands' => $prodBrandsArray,
        ]);
    }

    public function getCustomers() {
        try {
            // Fetching the customer names using Eloquent's pluck method
            $customers = Customer::pluck('custName');
        
            return response()->json([
                'customers' => $customers
            ]);
        } catch (\Exception $e) {
            // Returning a JSON response with an error message and a 500 status code
            return response()->json(['error' => 'An error occurred while fetching customers'], 500);
        }
    }
    
    
}
