<section>
    <header class="mb-2">
        <h2 class="text-lg font-medium text-gray-900">
            Lista de Afiliados ativos
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Algumas ações não estão disponíveis para Afiliados.
        </p>
    </header>
</section>
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Nome</th>
                <th class="px-4 py-2">E-Mail</th>
                <th class="px-4 py-2">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($affiliates as $affiliate)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $affiliate->name }}</td>
                <td class="px-4 py-2">{{ $affiliate->email }}</td>

                <td>
                    <div class="flex space-x-2">
                        <form action="{{ route('affiliate.edit', $affiliate->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Alterar</button>
                        </form>
                        <form action="{{ route('affiliate.destroy', $affiliate->id) }}" method="POST">
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
        {{ $affiliates->links() }}
    </div>
</div>
