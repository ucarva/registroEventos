<x-layouts.admin>
    <div class=" mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('admin.asistentes.index') }}" >Asistentes</flux:breadcrumbs.item>
                <flux:breadcrumbs.item >Nuevo</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            
    </div>  
    <div class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4 ">
        <form action="{{ route('admin.asistentes.store') }}" method="POST" class="p-5">
            @csrf
            <flux:input name="nombre" type="text" label="Nombre" value="{{ old('nombre') }}" />
            <flux:input name="apellido" type="text" label="Apellido" value="{{ old('apellido') }}" />
            <flux:input name="fecha_nacimiento" type="date" max="2999-12-31" label="Fecha nacimiento" value="{{ old('fecha_nacimiento') }}" />
            <flux:input name="email" type="email" label="Email" value="{{ old('email') }}" />
            <flux:input name="celular" type="num" label="Celular" value="{{ old('celular') }}" />

            
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Crear</flux:button>
            </div>
            
        </form>

    </div>

</x-layouts.admin>