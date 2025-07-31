<x-layouts.admin>
    <div class="flex justify-between items-center mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Categorias</flux:breadcrumbs.item>
        </flux:breadcrumbs>
         <a href="{{ route('admin.categorias.create') }}" class="btn btn-blue text-xs">
            Nuevo
        </a> 
      </div>  

    
{{-- nuestra tabla de categorias --}}
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
                
                <th scope="col" class="px-6 py-3 text-center" width="200">
                    Accion
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categorias as $categoria)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $categoria->id }}
                </th>
                <td class="px-6 py-4">
                    {{ $categoria->nombre_categoria }}
                </td>
                
                <td class="px-6 py-4">
                   <div class="flex items-center space-x-2">
                     <a href="{{ route('admin.categorias.edit',$categoria) }}" class="text-xs btn btn-green">Editar</a>
                    <form class="delete-form" action="{{ route('admin.categorias.destroy',$categoria) }}" method="POST">
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