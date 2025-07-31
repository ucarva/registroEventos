<x-layouts.admin>
    <div class="mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.cupones.index') }}">Entradas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-6">
        <h2 class="text-xl font-semibold text-gray-800">Crear entrada</h2>

        <form action="{{ route('admin.entradas.store') }}" method="POST" class="space-y-5">
            @csrf

            <flux:input
                name="tipo_entrada"
                type="text"
                label="Tipo de entrada"
                placeholder="VIP"
                value="{{ old('tipo_entrada') }}"
            />

            <flux:input
                name="porcentaje_adicional"
                type="number"
                min="1"
                max="100"
                step="1"
                label="Porcentaje de entrada (%)"
                placeholder="Ej: 15"
                value="{{ old('porcentaje_adicional') }}"
            />

            

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">crear entrada</flux:button>
            </div>
        </form>
    </div>
</x-layouts.admin>
