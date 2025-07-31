<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Asistente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AsistenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $asistentes = Asistente::orderBy('id', 'desc')->paginate(10);

        return view('admin.asistentes.index', compact('asistentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.asistentes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //Agregando validaciones

        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:asistentes,nombre',
            'apellido' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today|after:1900-01-01',
            'email' => 'required|email|max:255|unique:asistentes,email',
            'celular' => 'required|string|max:20|unique:asistentes,celular',
        ]);


        //creando el asistente
        Asistente::create($data);

        //variable de sesion de unico uso
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!Asistente creado',
            'text' => 'El asistente se ha creado correctamente.'
        ]);

        return redirect()->route('admin.asistentes.index');

        // dd($request->all());
    }

   
    
    public function edit(Asistente $asistente)
    {
        return view('admin.asistentes.edit', compact('asistente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asistente $asistente)
    {
     /*    \Log::info('Se ejecutó el update del asistente');
dd($request->all()); */

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'date', 'before:today', 'after:1900-01-01'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('asistentes', 'email')->ignore($asistente->id),
            ],
            'celular' => [
                'required',
                'string',
                'max:20',
                Rule::unique('asistentes', 'celular')->ignore($asistente->id),
            ],
        ]);

        $asistente->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!Asistente actualizado',
            'text' => 'El asistente se ha actualizado correctamente.',
        ]);

        return redirect()->route('admin.asistentes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asistente $asistente)
    {
        //
        $asistente->delete();

        //variable de sesion de unico uso
        session()->flash('swal',[
            'icon' => 'success',
            'title'=> '!asistente eliminado',
            'text'=>'El asistente se ha eliminado correctamente.'
        ]);

        return redirect()->route('admin.asistentes.index');
    }
    
}
