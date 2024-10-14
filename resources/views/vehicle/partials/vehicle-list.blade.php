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
                <th class="px-4 py-2">Placa</th>
                <th class="px-4 py-2">Renavam</th>
                <th class="px-4 py-2">Chassi</th>
                <th class="px-4 py-2">Fatura</th>
                <th class="px-4 py-2">Criado em</th>
                <th class="px-4 py-2">Status de Retorno</th>

                @if (Auth::user()->usertype >= 2)
                    <th class="px-4 py-2">Ação</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($vehicles as $vehicle)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $vehicle->id }}</td>
                    <td class="px-4 py-2">{{ $vehicle->placa }}</td>
                    <td class="px-4 py-2">{{ $vehicle->renavam }}</td>
                    <td class="px-4 py-2">{{ $vehicle->chassi }}</td>
                    <td class="px-4 py-2">{{ $vehicle->invoice_id }}</td>
                    <td class="px-4 py-2">{{ $vehicle->created_at }}</td>
                    <td class="px-4 py-2">{{ $vehicle->return_status }}</td>
                    @if (Auth::user()->usertype == 2)
                        <td>
                            <div class="flex space-x-2">
                                <form action="{{ route('vehicle.edit', $vehicle->id) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Alterar</button>
                                </form>

                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalDeletar_{{ $vehicle->id }}">
                                    Deletar
                                </button>
                                <div class="modal fade" id="modalDeletar_{{ $vehicle->id }}" tabindex="-1"
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
                                                <p>Tem certeza que deseja deletar o veículo
                                                    <strong>{{ $vehicle->placa }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('vehicle.destroy', $vehicle->id) }}"
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
                                    data-bs-target="#modalAprovar_{{ $vehicle->id }}">
                                    Aprovar
                                </button>
                                <div class="modal fade" id="modalAprovar_{{ $vehicle->id }}" tabindex="-1"
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
                                                <p>Tem certeza que deseja aprovar o veículo
                                                    <strong>{{ $vehicle->placa }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('vehicle.accept', $vehicle->id) }}"
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
                                    data-bs-target="#modalRejeitar_{{ $vehicle->id }}">
                                    Rejeitar
                                </button>
                                <div class="modal fade" id="modalRejeitar_{{ $vehicle->id }}" tabindex="-1"
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
                                                <p>Tem certeza que deseja rejeitar o veículo
                                                    <strong>{{ $vehicle->placa }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('vehicle.reject', $vehicle->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-dark btn-sm">Rejeitar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalDeletar_{{ $vehicle->id }}">
                                    Deletar
                                </button>
                                <div class="modal fade" id="modalDeletar_{{ $vehicle->id }}" tabindex="-1"
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
                                                <p>Tem certeza que deseja deletar o veículo
                                                    <strong>{{ $vehicle->placa }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('vehicle.destroy', $vehicle->id) }}"
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
        {{ $vehicles->links() }}
    </div>
</div>
