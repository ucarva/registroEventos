<x-layouts.admin>
    <div class="flex justify-between items-center mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Cupones</flux:breadcrumbs.item>
        </flux:breadcrumbs>
         <a href="{{ route('admin.cupones.create') }}" class="btn btn-blue text-xs">
            Nuevo
        </a> 
      </div>  

    
{{-- nuestra tabla de cupones --}}
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Nombre
                </th>
                <th scope="col" class="px-6 py-3">
                    Porcentaje
                </th>
                <th scope="col" class="px-6 py-3">
                    Fecha inicio
                </th>
                <th scope="col" class="px-6 py-3">
                    Fecha fin
                </th>
                
                <th scope="col" class="px-6 py-3 text-center" width="200">
                    Accion
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cupones as $cupon)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $cupon->id }}
                </th>
                <td class="px-6 py-4">
                    {{ $cupon->codigo_descuento }}
                </td>
                <td class="px-6 py-4">
                    {{ $cupon->porcentaje_descuento }}
                </td>
                <td class="px-6 py-4">
                    {{ $cupon->fecha_inicio }}
                </td>
                <td class="px-6 py-4">
                    {{ $cupon->fecha_fin }}
                </td>
                
                <td class="px-6 py-4">
                   <div class="flex items-center space-x-2">
                     <a href="{{ route('admin.cupones.edit',$cupon) }}" class="text-xs btn btn-green">Editar</a>
                    <form class="delete-form" action="{{ route('admin.cupones.destroy',$cupon) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-xs btn btn-red">
                            Eliminar
                        </button>
                    </form>
                   </div>
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
                        cancelButtonText:"Cancelar"
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