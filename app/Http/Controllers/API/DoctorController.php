<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return response()->json(Doctor::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'specialty' => 'required|string',
        ]);

        $doctor = Doctor::create($validated);

        return response()->json($doctor, 201);
    }
}
