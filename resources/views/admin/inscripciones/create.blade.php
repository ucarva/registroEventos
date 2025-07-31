<x-layouts.admin>
    <x-slot name="title">Nueva Inscripción</x-slot>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-2 rounded mb-3">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="form-inscripcion" method="POST" action="{{ route('admin.inscripciones.store') }}">
        @csrf

        @if ($evento)
            <input type="hidden" name="evento_id" value="{{ $evento->id }}">

            <flux:input name="nombre_evento" type="text" label="Nombre del evento" value="{{ $evento->titulo }}" disabled />
            <flux:input name="cupo_disponible" type="number" label="Cupo disponible" value="{{ $evento->cupo_disponible }}" disabled />
            <flux:input name="valor_base" type="text" label="Valor base (COP)" value="{{ $evento->valor_base_formato }}" disabled />
        @else
            <div class="text-red-600 font-semibold my-4">
                Debes seleccionar un evento desde la lista para continuar con la inscripción.
            </div>
        @endif

        {{-- Asistente --}}
        <flux:select label="Asistente" name="asistente_id" placeholder="Seleccione un asistente" required>
            @foreach ($asistentes as $asistente)
                <option value="{{ $asistente->id }}" @selected(old('asistente_id') == $asistente->id)>
                    {{ $asistente->nombre }}
                </option>
            @endforeach
        </flux:select>

        {{-- Entrada --}}
        <flux:select label="Entrada" name="entrada_id" id="entrada_id" placeholder="Seleccione un tipo de entrada" required>
            @foreach ($entradas as $entrada)
                <option value="{{ $entrada->id }}" @selected(old('entrada_id') == $entrada->id)>
                    {{ $entrada->tipo_entrada }}
                </option>
            @endforeach
        </flux:select>

        {{-- Cupones --}}
        <div class="mt-4">
            <label class="block text-sm font-semibold mb-1">Cupones (máximo 2)</label>

            <div class="flex gap-2">
                <input type="text" name="cupones[]" id="cupon_1" class="border rounded p-2 w-1/2" placeholder="Código cupón 1" value="{{ old('cupones.0') }}">
                <button type="button" id="btn-validar-cupon-1" class="bg-blue-500 text-white px-3 py-1 rounded">Validar</button>
            </div>

            <div class="flex gap-2 mt-2">
                <input type="text" name="cupones[]" id="cupon_2" class="border rounded p-2 w-1/2" placeholder="Código cupón 2" value="{{ old('cupones.1') }}">
                <button type="button" id="btn-validar-cupon-2" class="bg-blue-500 text-white px-3 py-1 rounded">Validar</button>
            </div>

            <p id="mensaje-cupon" class="text-sm mt-2"></p>
        </div>

        {{-- Campo oculto opcional (para debug/consistencia front) --}}
        <input type="hidden" name="valor_total_final" id="valor_total_final" value="">

        {{-- Campo oculto que usamos para cálculos front (el backend recalcula de todos modos) --}}
        <input type="hidden" name="valor_total" id="valor_total" value="">

        {{-- Campo visible: valor total --}}
        <flux:input id="valor_total_label" name="valor_total_label" type="text" label="Valor total a pagar (COP)" value="" disabled />

        {{-- Valor que se va a abonar --}}
        <flux:input name="valor_pago" id="valor_pago" type="number" step="0.01" min="0"
                    label="Valor que se va a pagar o abonar (COP)" value="{{ old('valor_pago') }}" required />
        @if ($errors->has('valor_pago'))
            <p class="text-red-600 text-sm mt-1">{{ $errors->first('valor_pago') }}</p>
        @endif

        {{-- Valor pendiente (se envía en hidden; el backend lo recalcula igual) --}}
        <input type="hidden" name="valor_pendiente" id="valor_pendiente" value="">
        <flux:input id="valor_pendiente_label" name="valor_pendiente_label" type="text"
                    label="Valor restante por pagar (COP)" value="" disabled />

        {{-- Estado del pago --}}
        <flux:select name="estado_pago" label="Estado de Pago" required>
            @foreach ($estadosPago as $valor => $label)
                <option value="{{ $valor }}" @selected(old('estado_pago') == $valor)>{{ $label }}</option>
            @endforeach
        </flux:select>

        <flux:button type="submit">
            Registrar inscripción
        </flux:button>
    </form>

    {{-- ======================= SCRIPT ======================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form                 = document.getElementById('form-inscripcion');
            const entradaSelect        = document.getElementById('entrada_id');
            const inputValorTotal      = document.getElementById('valor_total');
            const labelValorTotal      = document.getElementById('valor_total_label');
            const inputValorPago       = document.getElementById('valor_pago');
            const inputValorPendiente  = document.getElementById('valor_pendiente');
            const labelValorPendiente  = document.getElementById('valor_pendiente_label');
            const hiddenValorTotalFinal= document.getElementById('valor_total_final');

            const cupon1       = document.getElementById('cupon_1');
            const cupon2       = document.getElementById('cupon_2');
            const btnCup1      = document.getElementById('btn-validar-cupon-1');
            const btnCup2      = document.getElementById('btn-validar-cupon-2');
            const mensajeCupon = document.getElementById('mensaje-cupon');

            let totalOriginal = 0;
            let descuentoAcumulado = 0;
            const appliedCodes = new Set(); // evita aplicar el mismo cupón 2 veces en el front

            function formatoCOP(num) {
                return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(num);
            }

            function setMensajeCupon(texto, ok = false) {
                mensajeCupon.textContent = texto;
                mensajeCupon.classList.toggle('text-green-600', ok);
                mensajeCupon.classList.toggle('text-red-600', !ok);
            }

            function recalcularPendiente() {
                const total   = parseFloat(inputValorTotal.value) || 0;
                const abonado = parseFloat(inputValorPago.value) || 0;
                let pendiente = total - abonado;
                if (pendiente < 0) pendiente = 0;

                inputValorPendiente.value = pendiente;
                labelValorPendiente.value = formatoCOP(pendiente);
            }

            function actualizarTotalConDescuento() {
                let totalConDescuento = totalOriginal - descuentoAcumulado;
                // piso del 70% del TOTAL ORIGINAL (regla de negocio)
                const minimo = totalOriginal * 0.7;
                if (totalConDescuento < minimo) totalConDescuento = minimo;

                inputValorTotal.value = totalConDescuento;
                labelValorTotal.value = formatoCOP(totalConDescuento);
                hiddenValorTotalFinal.value = totalConDescuento; // opcional
                recalcularPendiente();
            }

            // Evita que ENTER en los inputs de cupón envíe el formulario
            function interceptEnterAndValidate(e, inputEl) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    validarCupon(inputEl);
                }
            }
            cupon1.addEventListener('keydown', (e) => interceptEnterAndValidate(e, cupon1));
            cupon2.addEventListener('keydown', (e) => interceptEnterAndValidate(e, cupon2));

            // Calcular total base según entrada
            entradaSelect.addEventListener('change', function () {
                const entradaId = this.value;
                const eventoId = document.querySelector('input[name="evento_id"]').value;
                if (!entradaId || !eventoId) return;

                fetch('{{ route('admin.inscripciones.calcular') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ evento_id: eventoId, entrada_id: entradaId })
                })
                .then(r => r.json())
                .then(data => {
                    totalOriginal = parseFloat(data.valor);
                    descuentoAcumulado = 0;
                    appliedCodes.clear();             // reinicia cupones al cambiar la entrada
                    inputValorTotal.value = totalOriginal;
                    labelValorTotal.value = formatoCOP(totalOriginal);
                    hiddenValorTotalFinal.value = totalOriginal;
                    setMensajeCupon('', true);
                    // no pongas readOnly ni disabled aquí
                    cupon1.readOnly = false;
                    cupon2.readOnly = false;
                    recalcularPendiente();
                })
                .catch(err => console.error('Error al calcular el valor:', err));
            });

            // Validar cupón
            function validarCupon(input) {
                const raw = input.value || '';
                const codigo = raw.toUpperCase().trim();
                const eventoId = document.querySelector('input[name="evento_id"]').value;

                if (!codigo) return;
                if (appliedCodes.has(codigo)) {
                    setMensajeCupon(`El cupón ${codigo} ya fue aplicado.`, false);
                    return;
                }
                if (appliedCodes.size >= 2) {
                    setMensajeCupon('Solo puedes aplicar máximo 2 cupones.', false);
                    return;
                }

                // Evitar clicks dobles mientras valida
                const btn = (input.id === 'cupon_1') ? btnCup1 : btnCup2;
                btn.disabled = true;

                fetch('{{ route('admin.inscripciones.validar-cupon') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ codigo: codigo, evento_id: eventoId })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.valido) {
                        appliedCodes.add(codigo);
                        // Marcar el input de cupón como solo-lectura para que SÍ se envíe en el POST (disabled NO se envía)
                        input.value = codigo;
                        input.readOnly = true;

                        const descuento = totalOriginal * (data.porcentaje / 100);
                        descuentoAcumulado += descuento;

                        setMensajeCupon(`Cupón ${codigo} aplicado (-${data.porcentaje}%).`, true);
                        actualizarTotalConDescuento();
                    } else {
                        setMensajeCupon(data.mensaje || 'Cupón inválido o vencido.', false);
                    }
                })
                .catch(err => {
                    console.error('Error al validar cupón:', err);
                    setMensajeCupon('No se pudo validar el cupón. Intenta nuevamente.', false);
                })
                .finally(() => {
                    btn.disabled = false;
                });
            }

            btnCup1.addEventListener('click', () => validarCupon(cupon1));
            btnCup2.addEventListener('click', () => validarCupon(cupon2));

            // Recalcular pendiente al escribir el abono
            inputValorPago.addEventListener('input', recalcularPendiente);

            // Antes de enviar, asegurar que total/pendiente están consistentes
            form.addEventListener('submit', function (e) {
                // Recalcula por seguridad (aunque backend recalcula)
                const total = parseFloat(inputValorTotal.value) || 0;
                const abonado = parseFloat(inputValorPago.value) || 0;
                let pendiente = total - abonado;
                if (pendiente < 0) pendiente = 0;

                inputValorPendiente.value = pendiente;
                hiddenValorTotalFinal.value = total;
            });
        });
    </script>
</x-layouts.admin>
