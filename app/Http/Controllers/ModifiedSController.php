<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Str;

class ModifiedSController extends Controller
{
    public function store(Request $request){

        try {
            $salesData = $request->validate([
                "prodID"=> "required|exists:products,id",
                "prodName" => "required",
                "prodBrand" => "required",
                "prodType" => "required",
                "prodSPrice" => "required|numeric",
                "prodOPrice" => "required|numeric",
                "qtySold" => "required|integer|min:1",
                "custName" => "required",
                "totalSales" => "required|numeric",
                "soldDate" => "required|date"
            ]);
    
            $product = Product::select('prodQty')
                        ->where('id', $salesData['prodID'])
                        ->first();
            
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            
            if ($salesData['qtySold'] > $product->prodQty) {
                return response()->json(['error' => 'Insufficient quantity']);
            }
            $latestTransactionNumber = Sale::latest()->value('transaction_number');
    
            if ($latestTransactionNumber === null) {
                // If there are no existing transactions, start with a default number
                $transno = 'APS' . 4200; // Generates a random string of length 6
            } else {
                // If there are existing transactions, increment the last transaction number
                // Extract numeric part from the transaction number and increment it
                $numericPart = (int) substr($latestTransactionNumber, 3); // Assuming the numeric part starts from the fourth character
                $numericPart++; // Increment the numeric part
                $transno = 'APS' . str_pad($numericPart, 6, '0', STR_PAD_LEFT); // Concatenate and pad with leading zeros if necessary
            }
            
    
            // Create a new sale record
            $newSale = Sale::create([
                'prodID'=> $salesData['prodID'],
                'prodName' => $salesData['prodName'],
                'prodBrand'=> $salesData['prodBrand'],
                'prodType'=> $salesData['prodType'],
                'prodSPrice'=> $salesData['prodSPrice'],
                'prodOPrice'=> $salesData['prodOPrice'],
                'qtySold'=> $salesData['qtySold'],
                'custName'=> $salesData['custName'],
                'totalSales'=> $salesData['totalSales'],
                'soldDate'=> $salesData['soldDate'],
                'transaction_number' => $transno
            ]);
    
            if($newSale){
                // Update product quantity
                $updated = Product::where('id', $salesData['prodID'])
                                ->decrement('prodQty', $salesData['qtySold']);
            
                if($updated){
                    return response()->json(['success' => 'Sale created successfully']);
                } else {
                    // Rollback sale if updating product quantity fails
                    $newSale->delete();
                    return response()->json(['error' => 'Failed to update product quantity'], 500);
                }
            } else {
                return response()->json(['error' => 'Failed to create sale record'], 500);
            }
    
    
            
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
    
        }
    
    
}
