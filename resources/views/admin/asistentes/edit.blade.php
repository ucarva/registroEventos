<x-layouts.admin>
    <div class=" mb-4">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('admin.asistentes.index') }}" >Asistentes</flux:breadcrumbs.item>
                <flux:breadcrumbs.item >Editar</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            
    </div>  
    <div class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4 ">
        <form action="{{ route('admin.asistentes.update', $asistente) }}" method="POST" class="p-5">
            @csrf
            @method('PUT')
            <flux:input name="nombre" type="text" label="Nombre" value="{{ old('nombre',$asistente->nombre) }}" />
            <flux:input name="apellido" type="text" label="Apellido" value="{{ old('apellido',$asistente->apellido) }}" />
            <flux:input name="email" type="email" label="Email" value="{{ $asistente->email }}" />
            <flux:input name="fecha_nacimiento" type="date" label="Fecha nacimiento" value="{{ $asistente->fecha_nacimiento }}" />
            <flux:input name="email" type="email" label="Email" value="{{ old('email',$asistente->email) }}" />
            <flux:input name="celular" type="text" label="Celular" value="{{ old('celular',$asistente->celular) }}" />
            
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Actualizar</flux:button>
            </div>
            
        </form>

    </div>

</x-layouts.admin>