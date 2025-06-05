<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function index()
    {
        return response()->json(Appointment::all());
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'required|string|exists:customers,id',
                'scheduled_at' => 'required|date',
                'doctor_id' => 'sometimes|string|exists:doctors,id',
                'notes' => 'nullable|string'
            ]);

            $appointment = Appointment::create($validated);

            return response()->json($appointment, 201);
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
            $appointment = Appointment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Agendamento não encontrado.',
            ], 404);
        }

        $validated = $request->validate([
            'scheduled_at' => 'sometimes|required|date',
            'notes' => 'nullable|string',
            'status' => 'sometimes|required|in:pending,confirmed,canceled',
        ]);

        $appointment->update($validated);

        return response()->json([
            'message' => 'Agendamento atualizado com sucesso.',
            'data' => $appointment,
        ]);
    }
}
