<x-layouts.admin>
    <div class="mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.cupones.index') }}">Cupones</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-6">
        <h2 class="text-xl font-semibold text-gray-800">Actualizar nuevo cupón de descuento</h2>

        <form action="{{ route('admin.cupones.update', $cupon) }}" method="POST" class="space-y-5">

            @csrf

            @method('PUT')

            <flux:input name="codigo_descuento" type="text" label="Código del cupón" placeholder="Ej: BIENVENIDO15"
                value="{{ old('codigo_descuento', $cupon->codigo_descuento) }}" />

            <flux:input name="porcentaje_descuento" type="number" min="1" max="100" step="1"
                label="Porcentaje de descuento (%)" placeholder="Ej: 15"
                value="{{ old('porcentaje_descuento', $cupon->porcentaje_descuento) }}" />

            <flux:input name="fecha_inicio" type="date" label="Fecha de inicio del cupón"
                value="{{ old('fecha_inicio', \Carbon\Carbon::parse($cupon->fecha_inicio)->format('Y-m-d')) }}" />

            <flux:input name="fecha_fin" type="date" label="Fecha de vencimiento"
                value="{{ old('fecha_fin', \Carbon\Carbon::parse($cupon->fecha_fin)->format('Y-m-d')) }}" />


            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Actualizar cupón</flux:button>
            </div>
        </form>
    </div>
</x-layouts.admin>
