<section>
    <header class="mb-2">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Registro de Consulta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Aviso do Registro') }}
        </p>
    </header>
</section>
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nome</th>
                <th class="px-4 py-2">RG</th>
                <th class="px-4 py-2">CPF</th>
                <th class="px-4 py-2">Nascimento</th>
                <th class="px-4 py-2">Pai</th>
                <th class="px-4 py-2">Mãe</th>
                <th class="px-4 py-2">CNH</th>
                <th class="px-4 py-2">Placa</th>
                <th class="px-4 py-2">Consultor</th>
                <th class="px-4 py-2">Criado em</th>
                <th class="px-4 py-2">Status de Retorno</th>

                @if (Auth::user()->usertype >= 2)
                    <th class="px-4 py-2">Ação</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($freelancers as $freelancer)
                @if ($freelancer->return_status == 'Em análise' || Auth::user()->usertype == 2)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $freelancer->id }}</td>
                        <td class="px-4 py-2">{{ $freelancer->name }}</td>
                        <td class="px-4 py-2">{{ $freelancer->rg }}</td>
                        <td class="px-4 py-2">{{ $freelancer->cpf }}</td>
                        <td class="px-4 py-2">{{ $freelancer->nascimento }}</td>
                        <td class="px-4 py-2">{{ $freelancer->pai }}</td>
                        <td class="px-4 py-2">{{ $freelancer->mae }}</td>
                        <td class="px-4 py-2">{{ $freelancer->cnh }}</td>
                        <td class="px-4 py-2">{{ $freelancer->placa }}</td>
                        <td class="px-4 py-2">{{ $freelancer->user_id }}</td>
                        <td class="px-4 py-2">{{ $freelancer->created_at }}</td>
                        <td class="px-4 py-2">{{ $freelancer->return_status }}</td>
                        @if (Auth::user()->usertype == 2)
                            <td>
                                <div class="flex space-x-2">
                                    <form action="{{ route('freelancer.edit', $freelancer->id) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Alterar</button>
                                    </form>
                                    <form action="{{ route('freelancer.destroy', $freelancer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                        @if (Auth::user()->usertype == 3)
                            <td>
                                <div class="flex flex-col space-y-2">
                                    <button type="button" class="btn btn-success btn-sm w-full" data-bs-toggle="modal"
                                        data-bs-target="#aprovar">
                                        Aprovar
                                    </button>
                                    <div class="modal fade" id="aprovar" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Aprovar
                                                        consulta
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja aprovar esta consulta?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Não</button>
                                                    <form action="{{ route('freelancer.accept', $freelancer->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success">Aprovar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-dark btn-sm w-full" data-bs-toggle="modal"
                                        data-bs-target="#recusar">
                                        Recusar
                                    </button>

                                    <div class="modal fade" id="recusar" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Recusar
                                                        consulta
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja recusar esta consulta?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Não</button>
                                                    <form action="{{ route('freelancer.reject', $freelancer->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-dark">Recusar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-danger btn-sm w-full" data-bs-toggle="modal"
                                        data-bs-target="#exclusao">
                                        Excluir
                                    </button>

                                    <div class="modal fade" id="exclusao" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir
                                                        consulta</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja apagar esta consulta?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Não</button>
                                                    <form action="{{ route('freelancer.destroy', $freelancer->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach

        </tbody>
    </table>
    <!-- Navegação de Paginação -->
    <div class="mt-4">
        {{ $freelancers->links() }}
    </div>
</div>
