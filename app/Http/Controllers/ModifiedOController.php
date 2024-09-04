<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Order;
use App\Models\Product;

class ModifiedOController extends Controller
{
    public function index(Request $request, $id) {
        // Update the status of the order to 1
        $order = DB::table('orders')
            ->where('id', $id) 
            ->update(['status' => '1']);
    
        if ($order) {
            // Retrieve the order data
            $orderData = DB::table('orders')->where('id', $id)->first();
            
            // Check if product exists in products table
            $existingProduct = Product::where('prodName', $orderData->prodName)->first();
            
            if ($existingProduct) {
                // Update existing product quantity
                $existingProduct->prodQty += $orderData->ordQty;
                $existingProduct->save();
            } else {
                // Create a new product using the order data
                Product::create([
                    'prodName' => $orderData->prodName,
                    'prodType' => $orderData->prodType,
                    'prodBrand' => $orderData->prodBrand,
                    'prodQty' => $orderData->ordQty,
                    'prodSPrice' => $orderData->prodSPrice,
                    'prodOPrice' => $orderData->prodOPrice
                ]);
            }
            
            return response()->json(['success' => 'Product order success']);
        } else {
            return response()->json(['failed' => 'Failed to update order status']);
        }
    }
}
