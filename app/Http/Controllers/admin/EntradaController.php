<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Entrada;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entradas = Entrada::orderBy('id', 'desc')->paginate(10);

        return view('admin.entradas.index', compact('entradas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.entradas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_entrada' => 'required|string|max:50',
            'porcentaje_adicional' => 'required|numeric|min:1|max:100',
            
        ]);

        // Crear el cupón
        Entrada::create($data);

        // Mensaje de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Entrada creado!',
            'text' => 'La Entrada se ha registrado correctamente.'
        ]);

        return redirect()->route('admin.entradas.index');
    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entrada $entrada)
    {
        return view('admin.entradas.edit', compact('entrada'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entrada $entrada)
    {
        $data = $request->validate([
       'tipo_entrada' => 'required|string|max:50',
       'porcentaje_adicional' => 'required|numeric|min:1|max:100',
    ]);

    $entrada->update($data);

    session()->flash('swal', [
        'icon' => 'success',
        'title' => '¡entrada actualizado!',
        'text' => 'La entrada se ha actualizado correctamente.'
    ]);

    return redirect()->route('admin.cupones.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entrada $entrada)
    {
        $entrada->delete();

        //variable de sesion de unico uso
        session()->flash('swal',[
            'icon' => 'success',
            'title'=> '!Entrada eliminado',
            'text'=>'La entrada se ha eliminado correctamente.'
        ]);

        return redirect()->route('admin.entradas.index');
    }
}
