<x-layouts.admin>
    <div class=" mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('admin.categorias.index') }}" >Categorias</flux:breadcrumbs.item>
                <flux:breadcrumbs.item >Editar</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            
    </div>  
    <div class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4 ">
        <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST" class="p-5">
            @csrf
            @method('PUT')
            <flux:input name="nombre_categoria" type="text" label="Nombre" value="{{ old('nombre_categoria',$categoria->nombre_categoria) }}" />
            
            
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Actualizar</flux:button>
            </div>
            
        </form>

    </div>

</x-layouts.admin>