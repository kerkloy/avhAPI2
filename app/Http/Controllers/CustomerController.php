<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();

        return response()->json(array('customers' => $customers));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $response = [];

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = $request ->validate([
            'custName' =>'required',
            'custCon' =>'required',
            'custAdr' =>'required'
        ]);

        $newCustomer = Customer::create($customer);

        if($newCustomer) {
                return response()->json(array('message' => 'Customer created successfully'));
        } else {
                return response()->json(array('message' => 'Customer creation failed'));
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
        $response = Customer::find($id);

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
        try {
            $validatedData = $request -> validate([
                'custName' =>'required',
                'custCon' =>'required',
                'custAdr' =>'required'
            ]);

            $customer = Customer::find($id);

            if(!$customer){
                return response()->json(array('message' => 'Customer not found'));
            }
            else{
                $customer->update([
                    'custName' => $validatedData['custName'],
                    'custCon' => $validatedData['custCon'],
                    'custAdr' => $validatedData['custAdr']
                ]);

                return response()->json(array('message' => 'Customer updated successfully'));
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
        $customer = Customer::find($id);

        if(!$customer){
            return response()->json(array('message' => 'Customer not found'));
        }
        else{
            $customer->delete();

            return response()->json(array('message' => 'Customer deleted successfully'));
        }
    }
}
