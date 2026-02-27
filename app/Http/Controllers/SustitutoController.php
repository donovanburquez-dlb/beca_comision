<?php

namespace App\Http\Controllers;

use App\Models\Maestro;
use App\Models\Sustituto;
use Illuminate\Http\Request;

class SustitutoController extends Controller
{
    public function store(Request $request, Maestro $maestro)
    {
        // 1. Validamos los datos que vienen del Modal
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'rfc'             => 'nullable|string|max:13',
            'telefono'        => 'nullable|string|max:20',
            'fecha_inicio'    => 'required|date',
            'fecha_termino'   => 'required|date|after_or_equal:fecha_inicio',
            'observaciones'   => 'nullable|string'
        ]);

        // 2. Asociamos automáticamente el ID del maestro al nuevo sustituto
        $validated['maestro_id'] = $maestro->id;
        $validated['estatus'] = 'ACTIVO'; // Estatus por defecto

        // 3. Guardamos en la base de datos
        Sustituto::create($validated);

        // 4. Recargamos la página con un mensaje de éxito
        return redirect()
            ->route('maestros.show', $maestro)
            ->with('success', 'Sustituto asignado correctamente.');
    }
}