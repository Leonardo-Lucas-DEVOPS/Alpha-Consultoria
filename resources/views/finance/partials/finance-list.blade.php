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
                <th class="px-4 py-2">Impressão de Fatura</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $company->Usuario }}</td>
                    <td class="px-4 py-2">{{ $company->Funcionarios }}</td>
                    <td class="px-4 py-2">{{ $company->Prestadores }}</td>
                    <td class="px-4 py-2">{{ $company->Veiculos }}</td>
                    <td class="px-4 py-2">V. Fat.</td>
                    <td class="px-4 py-2">
                        <div class="flex space-y-2">
                            <div class="actions">
                                <button class="btn btn-info">Gerar Fartura</button>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
