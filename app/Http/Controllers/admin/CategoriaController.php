<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::orderBy('id', 'desc')->paginate(10);

        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         //Agregando validaciones

        $data = $request->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias,nombre_categoria',
            
        ]);


        //creando el asistente
        Categoria::create($data);

        //variable de sesion de unico uso
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!Categoria creada',
            'text' => 'La Categoria se ha creado correctamente.'
        ]);

        return redirect()->route('admin.categorias.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
    return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
          $data = $request->validate([
            'nombre_categoria' => ['required', 'string', 'max:255'],
            
        ]);

        $categoria->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '!Categoria actualizado',
            'text' => 'La Categoria se ha actualizado correctamente.',
        ]);

        return redirect()->route('admin.categorias.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
         //
        $categoria->delete();

        //variable de sesion de unico uso
        session()->flash('swal',[
            'icon' => 'success',
            'title'=> '!categoria eliminada',
            'text'=>'La Categoria se ha eliminado correctamente.'
        ]);

        return redirect()->route('admin.categorias.index');
    }
    
}
