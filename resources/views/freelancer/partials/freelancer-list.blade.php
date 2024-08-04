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
                @if (Auth::user()->usertype >= 2)
                <th>
                    <div class="flex">
                        <a class="btn btn-primary mr-1" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" href="{{ route('freelancer.edit', ['id' => $freelancer->id]) }}">Editar</a>
                        <form action="{{ route('freelancer.destroy', $freelancer->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger ml-1" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Excluir</button>
                        </form>
                    </div>
                </th>
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