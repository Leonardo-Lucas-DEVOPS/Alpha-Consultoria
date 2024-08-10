<section>
    <header class="mb-2">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Registro de Consulta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Aviso do Registro") }}
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
                <td class="px-4 py-2">{{ $vehicle->user_id }}</td>
                <td class="px-4 py-2">{{ $vehicle->created_at }}</td>
                <td class="px-4 py-2">{{ $vehicle->return_status }}</td>
                @if (Auth::user()->usertype == 2)
                <td>
                    <div class="flex space-x-2">
                        <form action="{{ route('vehicle.edit', $vehicle->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Alterar</button>
                        </form>
                        <form action="{{ route('vehicle.destroy', $vehicle->id) }}" method="POST">
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
                        <form action="{{ route('vehicle.destroy', $vehicle->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-success btn-sm w-full">Aprovado</button>
                        </form>
                        <form action="{{ route('vehicle.destroy', $vehicle->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-dark btn-sm w-full">Rejeitado</button>
                        </form>
                        <form action="{{ route('vehicle.delete', $vehicle->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-full">Deletar</button>
                        </form>
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