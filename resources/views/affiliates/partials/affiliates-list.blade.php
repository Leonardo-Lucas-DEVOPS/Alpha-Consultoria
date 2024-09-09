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
                <th class="px-4 py-2">CPF/CNPJ</th>
                <th class="px-4 py-2">Telefone</th>
                <th class="px-4 py-2">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($affiliates as $affiliate)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $affiliate->name }}</td>
                <td class="px-4 py-2">{{ $affiliate->email }}</td>
                <td class="px-4 py-2">{{ $affiliate->cpf_cnpj}}</td>
                <td class="px-4 py-2">{{ $affiliate->phone}}</td>

                <td>
                    <div class="flex space-x-2">
                        <form action="{{ route('affiliate.edit', $affiliate->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Alterar</button>
                        </form>
                        <div class="actions">
                            <button class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#contactModal_{{ $affiliate->id }}">
                                Excluir
                            </button>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="contactModal_{{ $affiliate->id }}"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Atenção</h1>
                                    <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Tem certeza que deseja excluir o afiliado <strong>{{ $affiliate->name }}</strong>?</p>

                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('affiliate.destroy', $affiliate->id) }}" method="POST">
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
        {{ $affiliates->links() }}
    </div>
</div>