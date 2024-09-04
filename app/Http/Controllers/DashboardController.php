<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Order;
use DB;
use Carbon\Carbon;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalSales = Sale::sum('totalSales');
        $totalProfit = Sale::selectRaw('SUM(totalSales - (prodOprice * qtySold)) as totalProfit')->value('totalProfit');
        $today = Carbon::today();
        $incomeToday = Sale::whereDate('soldDate', $today)
        ->sum('totalSales');
        $totalCost = Order::whereNull('deleted_at')->sum('totalOrderPrice');

        return response()->json(array('totalSales' => $totalSales,'totalProfit' => $totalProfit, 'incomeToday' => $incomeToday,'totalCost' => $totalCost));
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
        //
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
        //
    }

    public function getSalesByBrand()
    {
        try {
            $results = DB::select('SELECT prodBrand, SUM(qtySold) as qtySold
            FROM sales
            GROUP BY prodBrand');
            

            // Return the results as JSON
            return response()->json(
                $results
            );
        } catch (\Exception $e) {
            // Handle exception and return error response
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
