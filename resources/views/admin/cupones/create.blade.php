<x-layouts.admin>
    <div class="mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.cupones.index') }}">Cupones</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-6">
        <h2 class="text-xl font-semibold text-gray-800">Crear nuevo cupón de descuento</h2>

        <form action="{{ route('admin.cupones.store') }}" method="POST" class="space-y-5">
            @csrf

            <flux:input
                name="codigo_descuento"
                type="text"
                label="Código del cupón"
                placeholder="Ej: BIENVENIDO15"
                value="{{ old('codigo_descuento') }}"
            />

            <flux:input
                name="porcentaje_descuento"
                type="number"
                min="1"
                max="100"
                step="1"
                label="Porcentaje de descuento (%)"
                placeholder="Ej: 15"
                value="{{ old('porcentaje_descuento') }}"
            />

            <flux:input
                name="fecha_inicio"
                type="date"
                label="Fecha de inicio del cupón"
                value="{{ old('fecha_inicio') }}"
            />

            <flux:input
                name="fecha_fin"
                type="date"
                label="Fecha de vencimiento"
                value="{{ old('fecha_fin') }}"
            />

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Guardar cupón</flux:button>
            </div>
        </form>
    </div>
</x-layouts.admin>
