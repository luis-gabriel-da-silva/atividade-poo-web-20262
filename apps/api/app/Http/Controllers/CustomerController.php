<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customers;
use App\Http\Requests\CustomerStoreRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Customers::paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request)
    {
        $data = $request->validated();

        $customers = Customers::create($data);

        return $customers;
    }

    /**
     * Display the specified resource.
     */
    public function show(Customers $customers)
    {
        return $customers;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Customers $customers, CustomerUpdateRequest $request)
    {
        $data = $request->validated();

        $customers->update($data);

        return $customers;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customers $customers)
    {
        $customers->delete();

        return response()->json([
            'message' => 'Cliente excluído com sucesso',
        ], 200);
    }
}