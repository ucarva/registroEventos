<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Entrada;
use App\Models\Inscripcion;
use App\Models\Cupon;
use App\Models\ListaEspera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscripcionController extends Controller
{
    public function index()
    {
        $inscripciones = Inscripcion::with(['evento', 'asistente'])->latest()->get();
        return view('admin.inscripciones.index', compact('inscripciones'));
    }

    public function create(Request $request)
    {
        $asistentes = \App\Models\Asistente::all();
        $entradas = \App\Models\Entrada::all();
        $evento = null;
        $estadosPago = Inscripcion::getEstadosPago();

        if ($request->has('evento_id')) {
            $evento = Evento::findOrFail($request->evento_id);
        }

        return view('admin.inscripciones.create', compact('asistentes', 'entradas', 'evento', 'estadosPago'));
    }


   public function store(Request $request)
{
    // Validaciones base
    $request->validate([
        'evento_id'    => 'required|exists:eventos,id',
        'asistente_id' => 'required|exists:asistentes,id',
        'entrada_id'   => 'required|exists:entradas,id',
        'valor_pago'   => 'required|numeric|min:0',
        'estado_pago'  => 'required|string',
        'valor_total'  => 'required|numeric|min:0', // <- nuevo: total con cupones
    ]);

    $evento  = Evento::findOrFail($request->evento_id);
    $entrada = Entrada::findOrFail($request->entrada_id);

    // Total enviado desde el front (ya con cupones aplicados)
    $totalFinal = (float) $request->valor_total;

    // ------------------------------
    // Validaciones sobre el abono
    // ------------------------------
    $abonoUsuario = (float) $request->valor_pago;

    if ($request->estado_pago === 'pagado' && $abonoUsuario < $totalFinal) {
        return back()->withInput()->withErrors([
            'valor_pago' => 'Para marcar como pagado, debe abonar el total (' .
                number_format($totalFinal, 0, ',', '.') . ' COP).'
        ]);
    }

    if ($request->estado_pago === 'pendiente' && $abonoUsuario > $totalFinal) {
        return back()->withInput()->withErrors([
            'valor_pago' => 'El valor ingresado no puede ser mayor al total a pagar (' .
                number_format($totalFinal, 0, ',', '.') . ' COP).'
        ]);
    }

    $valorPendiente = max($totalFinal - $abonoUsuario, 0);

    // ------------------------------
    // Guardar inscripción
    // ------------------------------
    DB::beginTransaction();
    try {
        Inscripcion::create([
            'evento_id'       => $evento->id,
            'asistente_id'    => $request->asistente_id,
            'entrada_id'      => $entrada->id,
            'valor_pago'      => $abonoUsuario,
            'valor_pendiente' => $valorPendiente,
            'estado_pago'     => $request->estado_pago,
        ]);

        DB::commit();
    } catch (\Throwable $th) {
        DB::rollBack();
        return back()->withInput()->withErrors([
            'error' => 'Ocurrió un error al registrar la inscripción.'
        ]);
    }

    session()->flash('swal', [
        'icon' => 'success',
        'title' => '¡Inscripción creada!',
        'text' => 'La inscripción se ha creado correctamente.'
    ]);

    return redirect()->route('admin.eventos.index');
}




    public function calcularValorEntrada(Request $request)
    {
        $evento = Evento::findOrFail($request->evento_id);
        $entrada = Entrada::findOrFail($request->entrada_id);

        $valorFinal = $entrada->calcularValorConEvento($evento);

        return response()->json([
            'valor' => $valorFinal,
            'formato' => '$' . number_format($valorFinal, 0, ',', '.')
        ]);
    }
    public function validarCupon(Request $request)
    {
        $request->validate([
            'codigo'    => 'required|string',
            'evento_id' => 'required|exists:eventos,id',
        ]);

        $eventoId = $request->evento_id;
        $codigo   = strtoupper(trim($request->codigo));

        // Buscar cupón válido
        $cupon = \App\Models\Cupon::where('codigo_descuento', $codigo)
            ->whereDate('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now())
            ->first();

        if (!$cupon) {
            return response()->json([
                'valido'  => false,
                'mensaje' => 'Cupón inválido o fuera de vigencia.'
            ]);
        }

        return response()->json([
            'valido'     => true,
            'porcentaje' => $cupon->porcentaje_descuento,
            'mensaje'    => 'Cupón válido.'
        ]);

      
    }



    public function show(Inscripcion $inscripcion)
    {
        return view('admin.inscripciones.show', compact('inscripcion'));
    }

    public function edit(Inscripcion $inscripcion)
    {
        abort(403); // Edición deshabilitada por lógica de negocio
    }

    public function destroy(Inscripcion $inscripcion)
    {
        $inscripcion->delete();
        return redirect()->route('inscripciones.index')->with('success', 'Inscripción eliminada correctamente.');
    }
}
