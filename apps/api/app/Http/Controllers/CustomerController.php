<?php
namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Lista os clientes com paginação.
     */
    public function index()
    {
        return Customer::paginate(10);
    }

    /**
     * Cadastra um novo cliente.
     */
    public function store(CustomerStoreRequest $request)
    {
        $data = $request->validated();

        $customer = Customer::create($data);

        return response()->json($customer, 201);
    }

    /**
     * Exibe um cliente específico.
     */
    public function show(Customer $customer)
    {
        return response()->json($customer, 200);
    }

    /**
     * Atualiza um cliente.
     */
    public function update(
        CustomerUpdateRequest $request,
        Customer $customer
    ) {
        $data = $request->validated();

        $customer->update($data);

        return response()->json($customer, 200);
    }

    /**
     * Exclui um cliente.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'message' => 'Cliente excluído com sucesso',
        ], 200);
    }
}
