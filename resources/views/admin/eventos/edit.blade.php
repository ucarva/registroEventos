<x-layouts.admin>
    <div class=" mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.eventos.index') }}">Eventos</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
        </flux:breadcrumbs>

    </div>
    <div class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4 ">
        <form action="{{ route('admin.eventos.update', $evento) }}" method="POST" class="p-5">
            @csrf
            @method('PUT')
            <flux:input name="titulo" type="text" label="Título del evento"
                value="{{ old('titulo', $evento->titulo) }}" />

            <flux:input name="descripcion" type="textarea" label="Descripción"
                value="{{ old('descripcion', $evento->descripcion) }}" />

                
            <input type="hidden" name="es_gratuito" value="1">

            <flux:checkbox name="es_gratuito" label="¿Es gratuito?" value="0"
                :checked="old('es_gratuito', $evento->es_gratuito) == 0" />




            <flux:input name="fecha_evento" type="date" label="Fecha del evento"
                value="{{ old('fecha_evento', $evento->fecha_evento) }}" />

            <flux:input name="hora_evento" type="time" label="Hora del evento"
                value="{{ old('hora_evento', $evento->hora_evento) }}" />

            <flux:input name="fecha_apertura" type="date" label="Fecha de apertura de inscripciones"
                value="{{ old('fecha_apertura', $evento->fecha_apertura) }}" />

            <flux:input name="fecha_cierre" type="date" label="Fecha de cierre de inscripciones"
                value="{{ old('fecha_cierre', $evento->fecha_cierre) }}" />

            <flux:input name="lugar" type="text" label="Lugar del evento"
                value="{{ old('lugar', $evento->lugar) }}" />

            <flux:input name="cupo_disponible" type="number" min="1" label="Cupo disponible"
                value="{{ old('cupo_disponible', $evento->cupo_disponible) }}" />

            <flux:input name="valor_base" type="number" step="0.01" min="0" label="Valor base (COP)"
                value="{{ old('valor_base', $evento->valor_base) }}" />

            <flux:select label="Categoría" name="categoria_id" placeholder="Seleccione una categoría">
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(old('categoria_id', $evento->categoria_id ?? '') == $categoria->id)>
                        {{ $categoria->nombre_categoria }}
                    </option>
                @endforeach
            </flux:select>



            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Actualizar</flux:button>
            </div>

        </form>

    </div>

</x-layouts.admin>
