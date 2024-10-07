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
                <th class="px-4 py-2">Valor da Fatura</th>
                <th class="px-4 py-2">Gerencimento de Fatura</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $company->Company }}</td>
                    <td class="px-4 py-2">{{ $company->Employees }}</td>
                    <td class="px-4 py-2">{{ $company->Freelancers }}</td>
                    <td class="px-4 py-2">{{ $company->Vehicles }}</td>
                    <td class="px-4 py-2">R${{ $company->Price }}.00</td>
                    <td class="px-4 py-2">
                        <div class="flex space-y-2">
                            <div class="actions">
                                <button class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#modalInvoice_{{ $company->id }}">Gerenciar Fatura</button>
                                <form action="{{ route('finance.update', $company->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal fade" id="modalInvoice_{{ $company->id }}" tabindex="-1"
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
                                                        <strong>{{ $company->Company }}</strong>
                                                        com seus respectivos custos
                                                    </p>

                                                    <label for="valueEmployee_{{ $company->id }}">Funcionário
                                                        (Empresa: {{ $company->Company }})</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control"
                                                            id="valueEmployee_{{ $company->id }}"
                                                            name="valueEmployee[{{ $company->id }}]"
                                                            value="{{ $company->cost_Employee ?? 0 }}"
                                                            aria-label="Preço para cada funcionário da empresa {{ $company->Company }}">
                                                        <span class="input-group-text">.00</span>
                                                    </div>

                                                    <label for="valueFreelancer_{{ $company->id }}">Prestador de serviço
                                                        (Empresa: {{ $company->Company }})</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control"
                                                            id="valueFreelancer_{{ $company->id }}"
                                                            name="valueFreelancer[{{ $company->id }}]"
                                                            value="{{ $company->cost_Freelancer ?? 0 }}"
                                                            aria-label="Preço para cada prestador de serviço da empresa {{ $company->Company }}">
                                                        <span class="input-group-text">.00</span>
                                                    </div>

                                                    <label for="valueVehicle_{{ $company->id }}">Veículo
                                                        (Empresa: {{ $company->Company }})</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control"
                                                            id="valueVehicle_{{ $company->id }}"
                                                            name="valueVehicle[{{ $company->id }}]"
                                                            value="{{ $company->cost_Vehicle ?? 0 }}"
                                                            aria-label="Preço para cada veículo da empresa {{ $company->Company }}">
                                                        <span class="input-group-text">.00</span>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">

                                                    <button class="btn btn-primary">Estabelecer preços</button>
                                </form>

                                <form action="{{ route('finance.invoice', $company->id) }}" method="GET">
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
