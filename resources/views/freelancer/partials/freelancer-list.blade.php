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

                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalDeletar_{{ $freelancer->id }}">
                                    Deletar
                                </button>
                                <div class="modal fade" id="modalDeletar_{{ $freelancer->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Atenção</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Tem certeza que deseja deletar o(a) prestador de serviço
                                                    <strong>{{ $freelancer->name }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('freelancer.destroy', $freelancer->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm">Deletar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    @endif
                    @if (Auth::user()->usertype == 3)
                        <td>
                            <div class="flex flex-col space-y-2">
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalAprovar_{{ $freelancer->id }}">
                                    Aprovar
                                </button>
                                <div class="modal fade" id="modalAprovar_{{ $freelancer->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Atenção</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Tem certeza que deseja aprovar o prestador de serviço
                                                    <strong>{{ $freelancer->name }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('freelancer.accept', $freelancer->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-success btn-sm">Aprovar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalRejeitar_{{ $freelancer->id }}">
                                    Rejeitar
                                </button>
                                <div class="modal fade" id="modalRejeitar_{{ $freelancer->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Atenção</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Tem certeza que deseja rejeitar o prestador de serviço
                                                    <strong>{{ $freelancer->name }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('freelancer.reject', $freelancer->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-dark btn-sm">Rejeitar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalDeletar_{{ $freelancer->id }}">
                                    Deletar
                                </button>
                                <div class="modal fade" id="modalDeletar_{{ $freelancer->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Atenção</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Tem certeza que deseja deletar o prestador de serviço
                                                    <strong>{{ $freelancer->name }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('freelancer.destroy', $freelancer->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm">Deletar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach

        </tbody>
    </table>
    <!-- Navegação de Paginação -->
    <div class="mt-4">
        {{ $freelancers->links() }}
    </div>
</div>
