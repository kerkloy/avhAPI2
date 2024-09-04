<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AlertController extends Controller
{
    public function index() {
        try {
            $today = Carbon::today();
            $data = DB::table('sales')
                        ->select('prodName', 'prodType', 'totalSales', 'qtySold', 'transaction_number', 'soldDate')
                        ->whereDate('soldDate', $today)
                        ->orderBy('soldDate', 'DESC')
                        ->get();
    
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching sale data'], 500);
        }
    }
}
