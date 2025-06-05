<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return response()->json([
            'message' => 'Lista de clientes',
            'data' => $customers,
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('phone', $request->phone)->first();

        if (! $customer || ! Hash::check($request->password, $customer->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas.',
                'data' => null
            ], 401);
        }

        $token = $customer->createToken('customer-login')->plainTextToken;

        return response()->json([
            'message' => 'Login realizado com sucesso.',
            'data' => [
                'customer' => $customer,
                'token' => $token,
            ],
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'phone' => 'required|unique:customers',
                'password' => 'required',
            ]);

            $customer = Customer::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json([
                'message' => 'Cliente criado com sucesso.',
                'data' => $customer,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação.',
                'data' => $e->errors(), // array de campos com erros
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cliente não encontrado.',
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|unique:customers,phone,' . $id . ',id',
            'password' => 'sometimes|string|min:6',
        ]);


        if ($request->has('name')) {
            $customer->name = $request->name;
        }

        if ($request->has('phone')) {
            $customer->phone = $request->phone;
        }

        if ($request->has('password')) {
            $customer->password = Hash::make($request->password);
        }

        $customer->save();

        return response()->json([
            'message' => 'Cliente atualizado com sucesso.',
            'data' => $customer,
        ]);
    }

    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cliente não encontrado.',
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Cliente removido com sucesso.'
        ]);
    }
}
