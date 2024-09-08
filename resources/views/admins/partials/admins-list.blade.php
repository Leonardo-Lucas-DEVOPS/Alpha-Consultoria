<section>
    <header class="mb-2">
        <h2 class="text-lg font-medium text-gray-900">
            Lista de Adminstradores ativos
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Todos os Adminstradores ativos
        </p>
    </header>
</section>
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Nome</th>
                <th class="px-4 py-2">E-Mail</th>
                <th class="px-2 py-1">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $admin->name }}</td>
                    <td class="px-4 py-2">{{ $admin->email }}</td>

                    <td>
                        <div class="flex space-x-2">
                            <form action="{{ route('admin.destroy', $admin->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </div>
                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>
    <!-- Navegação de Paginação -->
    <div class="mt-4">
        {{ $admins->links() }}
    </div>
</div>
