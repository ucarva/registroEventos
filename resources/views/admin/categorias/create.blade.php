<x-layouts.admin>
    <div class=" mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('admin.asistentes.index') }}" >Categorias</flux:breadcrumbs.item>
                <flux:breadcrumbs.item >Nuevo</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            
    </div>  
    <div class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4 ">
        <form action="{{ route('admin.categorias.store') }}" method="POST" class="p-5">
            @csrf
            <flux:input name="nombre_categoria" type="text" label="Nombre" value="{{ old('nombre_categoria') }}" />
           

            
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Crear</flux:button>
            </div>
            
        </form>

    </div>

</x-layouts.admin>