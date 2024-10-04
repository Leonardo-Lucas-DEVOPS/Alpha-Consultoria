<section>
    <header class="mb-2">
        <h2 class="text-lg font-medium text-gray-900">
            Relatório de Finanças Empresariais
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Faturas de todas as empresas
        </p>
    </header>
</section>

<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Empresa</th>
                <th class="px-4 py-2">N° Funcionários</th>
                <th class="px-4 py-2">N° Prestadores de Serviço</th>
                <th class="px-4 py-2">N° Veículos</th>
                <th class="px-4 py-2">Valor da Fatura em R$</th>
                <th class="px-4 py-2">Gerencimento de Fatura</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $company->Usuario }}</td>
                    <td class="px-4 py-2">{{ $company->Funcionarios }}</td>
                    <td class="px-4 py-2">{{ $company->Prestadores }}</td>
                    <td class="px-4 py-2">{{ $company->Veiculos }}</td>
                    <td class="px-4 py-2">R$.</td>
                    <td class="px-4 py-2">
                        <div class="flex space-y-2">
                            <div class="actions">
                                <button class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#modalFatura_{{ $company->id }}">Gerenciar Fatura</button>

                                    <form action="{{ route('finance.update', $company->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                <div class="modal fade" id="modalFatura_{{ $company->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Fatura Empresarial</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Edite e gere uma fatura para a empresa
                                                    <strong>{{ $company->Usuario }}</strong>
                                                    com seus respectivos custos
                                                </p>

                                                <label for="valorFuncionario">Funcionário</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">$</span>
                                                    <input type="text" class="form-control" id="valorFuncionario"
                                                        name="valorFuncionario" value="{{ $company->ValorFuncionarios }}"
                                                        aria-label="Preço para cada funcionário">
                                                    <span class="input-group-text">.00</span>
                                                </div>

                                                {{-- <label for="prestador">Prestador de serviço</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">$</span>
                                                    <input type="text" class="form-control" id="prestador"
                                                        name="prestador" value="{{ $company->ValorPrestadores }}"
                                                        aria-label="Preço para cada prestador de serviço">
                                                    <span class="input-group-text">.00</span>
                                                </div>

                                                <label for="veiculo">Veículo</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">$</span>
                                                    <input type="text" class="form-control" id="veiculo"
                                                        name="veiculo" value="{{ $company->ValorVeiculos}}"
                                                        aria-label="Preço para cada veículo">
                                                    <span class="input-group-text">.00</span>
                                                </div> --}}
                                            </div>
                                            <div class="modal-footer">
                                                    <button class="btn btn-primary">Estabelecer preços</button>
                                                </form>

                                                <form action="{{ route('finance.invoice', $company->id) }}"
                                                    method="GET">
                                                    <button class="btn btn-info">Gerar Fatura</button>
                                                </form>
                                            </div>
                                        </div>
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
        {{ $companies->links() }}
    </div>
</div>
