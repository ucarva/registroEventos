<x-layouts.admin>
    <div class="flex justify-between items-center mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Eventos</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.eventos.create') }}" class="btn btn-blue text-xs">
            Nuevo
        </a>
    </div>


    {{-- nuestra tabla de eventos --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>

                    <th scope="col" class="px-6 py-3">
                        Evento
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Asistente
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tipo entrada
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Valor Pago
                    </th>
                    <th scope="col" class="px-6 py-3 text-center" width="200">
                        Estado Pago
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($inscripciones as $inscripcion)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $inscripcion->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $inscripcion->evento->titulo }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $inscripcion->asistente->titulo }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $inscripcion->evento->descripcion ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $inscripcion->evento->es_gratuito ? 'Gratis' : 'Pago' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $inscripcion->evento->fecha_evento ?? '-'}}
                        </td>
                        <td class="px-6 py-4">
                            {{ $inscripcion->evento->fecha_apertura ?? '-'}}
                        </td>

                        <td class="px-6 py-4">
                            {{ $evento->fecha_cierre ?? '-'}}
                        </td>
                        <td class="px-6 py-4">
                            {{ $evento->hora_evento?? '-'}}
                        </td>
                        <td class="px-6 py-4">
                            {{ $evento->lugar ?? '-'}}
                        </td>
                        <td class="px-6 py-4">
                            {{ $evento->cupo_disponible ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $evento->valor_base_formato ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $evento->categoria->nombre_categoria ?? 'No asignado' }}
                        </td>

                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- el archivo js para la confirmacion de eliminar --}}
    @push('js')
        {{-- que se mantenga escuchando todo los formulario con clase delete-form --}}
        <script>
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    Swal.fire({
                        title: "Estas seguro?",
                        text: "No podras revertir esto!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, eliminar!",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });

            });
        </script>
    @endpush


</x-layouts.admin>
