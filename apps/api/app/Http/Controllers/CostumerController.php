<?php

namespace App\Http\Controllers;

use App\Http\Requests\CostumerUpdateRequest;
use App\Models\Costumers;
use App\Http\Requests\CostumerStoreRequest;

class CostumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Costumers::paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CostumerStoreRequest $request)
    {

        $data = $request->validated();

        $costumers = Costumers::create($data);

        return $costumers;

    }

    /**
     * Display the specified resource.
     */
    public function show(Costumers $costumers)
    {
        return $costumers;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Costumers $costumers, CostumerUpdateRequest $request)
    {
        $data = $request->validated();

        $costumers->update($data);

        return $costumers;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Costumers $costumers)
    {
        $costumers->delete();

        return response()->json([
            'message' => 'Cliente excluído com sucesso',
        ], 200);
    }
}