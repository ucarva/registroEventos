<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cupon;
use Illuminate\Http\Request;

class CuponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cupones = Cupon::orderBy('id', 'desc')->paginate(10);

        return view('admin.cupones.index', compact('cupones'));
    }


    public function validar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
            'evento_id' => 'required|exists:eventos,id',
        ]);

        $codigo = $request->input('codigo');
        $eventoId = $request->input('evento_id');

        // Buscar cupón
        $cupon = Cupon::where('codigo_descuento', $codigo)->first();

        if (!$cupon) {
            return response()->json(['success' => false, 'message' => 'Cupón no encontrado.'], 404);
        }

        // Validar fechas
        $hoy = now();
        if ($cupon->fecha_inicio > $hoy || $cupon->fecha_fin < $hoy) {
            return response()->json(['success' => false, 'message' => 'Cupón fuera de vigencia.'], 400);
        }

        // Validar si ya se usó 2 veces en este evento
        $usos = $cupon->inscripciones()->where('evento_id', $eventoId)->count();
        if ($usos >= 2) {
            return response()->json(['success' => false, 'message' => 'Este cupón ya fue usado dos veces para este evento.'], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cupón válido.',
            'descuento' => $cupon->porcentaje_descuento,
            'cupon_id' => $cupon->id,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cupones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo_descuento' => 'required|string|max:50|unique:cupones,codigo_descuento',
            'porcentaje_descuento' => 'required|numeric|min:1|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Crear el cupón
        Cupon::create($data);

        // Mensaje de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Cupón creado!',
            'text' => 'El cupón de descuento se ha registrado correctamente.'
        ]);

        return redirect()->route('admin.cupones.index');
    }



    public function edit(Cupon $cupon)
    {
        return view('admin.cupones.edit', compact('cupon'));
    }

    public function update(Request $request, Cupon $cupon)
    {
        $data = $request->validate([
            'codigo_descuento' => 'required|string|max:50|unique:cupones,codigo_descuento,' . $cupon->id,
            'porcentaje_descuento' => 'required|numeric|min:1|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $cupon->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Cupón actualizado!',
            'text' => 'El cupón de descuento se ha actualizado correctamente.'
        ]);

        return redirect()->route('admin.cupones.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cupon $cupon)
    {
        $cupon->delete();

        //variable de sesion de unico uso
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!cupon eliminado',
            'text' => 'El cupon se ha eliminado correctamente.'
        ]);

        return redirect()->route('admin.cupones.index');
    }
}
