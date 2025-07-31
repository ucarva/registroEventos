<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Categoria;
use App\Models\Organizador;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function detalle($id)
    {
        $evento = Evento::findOrFail($id);
        return response()->json($evento);
    }

    public function index()
    {
        $eventos = Evento::orderBy('id', 'desc')->paginate(10);

        return view('admin.eventos.index', compact('eventos'));
    }

    public function create()
    {
        $categorias = Categoria::all(); // ✅ Aquí obtenemos las categorías
        return view('admin.eventos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'es_gratuito' => 'nullable|boolean',
            'fecha_apertura' => 'required|date',
            'fecha_cierre' => 'required|date',
            'fecha_evento' => 'required|date',
            'hora_evento' => 'required',
            'lugar' => 'required|string|max:255',
            'cupo_disponible' => 'required|integer|min:0',
            'valor_base' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Evento::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Evento creado!',
            'text' => 'El evento se ha creado correctamente.'
        ]);

        return redirect()->route('admin.eventos.index');
    }




    public function edit(Evento $evento)
    {
        $categorias = Categoria::all();
        return view('admin.eventos.edit', compact('evento', 'categorias'));
    }

    public function update(Request $request, Evento $evento)
    {
        // Asegurar valor booleano aunque no venga en el request
        $evento->es_gratuito = $request->input('es_gratuito'); // recibirá "0" si marcado, "1" si no
        $evento->save();


        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'es_gratuito' => 'nullable|boolean',
            'fecha_apertura' => 'required|date',
            'fecha_cierre' => 'required|date',
            'fecha_evento' => 'required|date',
            'hora_evento' => 'required',
            'lugar' => 'required|string|max:255',
            'cupo_disponible' => 'required|integer|min:0',
            'valor_base' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $evento->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!Evento actualizado',
            'text' => 'El Evento se ha actualizado correctamente.',
        ]);

        return redirect()->route('admin.eventos.index');
    }


    public function destroy(Evento $evento)
    {
        $evento->delete();
        //variable de sesion de unico uso
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!Evento eliminado',
            'text' => 'El evento se ha eliminado correctamente.'
        ]);

        return redirect()->route('admin.eventos.index');
    }
}
