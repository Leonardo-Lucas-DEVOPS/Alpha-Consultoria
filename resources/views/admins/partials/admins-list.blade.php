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
                <th class="px-4 py-2">CPF/CNPJ</th>
                <th class="px-4 py-2">Telefone</th>
                <th class="px-2 py-1">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $admin->name }}</td>
                    <td class="px-4 py-2">{{ $admin->email }}</td>
                    <td class="px-4 py-2">{{ $admin->cpf_cnpj }}</td>
                    <td class="px-4 py-2">{{ $admin->phone }}</td>

                    <td>
                        <!-- button da modal -->
                        <div class="flex space-x-2">
                            <div class="actions">
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#contactModal_{{ $admin->id }}">
                                    Excluir
                                </button>
                            </div>
                        </div>
                        <!-- modal  -->
                        <div class="modal fade" id="contactModal_{{ $admin->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Atenção</h1>
                                        <!-- button close -->
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Tem certeza que deseja excluir o Admin <strong>{{ $admin->name }}</strong>?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('admin.destroy', $admin->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
