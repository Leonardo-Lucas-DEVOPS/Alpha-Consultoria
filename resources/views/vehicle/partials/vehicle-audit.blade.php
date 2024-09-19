<section>
    <header class="mb-2">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Auditoria') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Aviso Auditoria') }}
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
                <th class="px-4 py-2">Consultor</th>
                <th class="px-4 py-2">Alterado em</th>
                <th class="px-4 py-2">Status de Retorno</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($olddatas as $olddata)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $olddata->vehicle_id }}</td>
                    <td class="px-4 py-2">{{ $olddata->OldPlaca }}</td>
                    <td class="px-4 py-2">{{ $olddata->OldRenavam }}</td>
                    <td class="px-4 py-2">{{ $olddata->OldChassi }}</td>
                    <td class="px-4 py-2">{{ $olddata->OldUser_id }}</td>
                    <td class="px-4 py-2">{{ $olddata->created_at }}</td>
                    <td class="px-4 py-2">{{ $olddata->OldReturn_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Navegação de Paginação -->
    <div class="mt-4">
        {{ $olddatas->links() }}
    </div>
</div>
