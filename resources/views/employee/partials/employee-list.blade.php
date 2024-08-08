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
                    @if (Auth::user()->usertype >= 2 && $page === 'show')
                    <th class="px-4 py-2">Consultor</th>
                    <th class="px-4 py-2">Criado em</th>
                @endif
                <th class="px-4 py-2">Status de Retorno</th>

                @if (Auth::user()->usertype >= 2)
                <th class="px-4 py-2">Ação</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $employee->id }}</td>
                <td class="px-4 py-2">{{ $employee->name }}</td>
                <td class="px-4 py-2">{{ $employee->rg }}</td>
                <td class="px-4 py-2">{{ $employee->cpf }}</td>
                <td class="px-4 py-2">{{ $employee->nascimento }}</td>
                <td class="px-4 py-2">{{ $employee->pai }}</td>
                <td class="px-4 py-2">{{ $employee->mae }}</td>
                
                @if (Auth::user()->usertype >= 2 && $page === 'show')
                <td class="px-4 py-2">{{ $employee->user_id }}</td>
                <td class="px-4 py-2">{{ $employee->created_at }}</td>
                
                @endif
                <td class="px-4 py-2">{{ $employee->return_status }}</td>
                @if (Auth::user()->usertype >= 2 && $page === 'show')
                <th>
                    <div class="flex">
                        <a class="btn btn-primary ml-2 m-1  " style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" href="{{ route('employee.edit', ['id' => $employee->id]) }}">Alterar</a>
                        <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger m-1 " style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Remover</button>
                        </form>
                    </div>
                </th>
                @endif
                @if (Auth::user()->usertype >= 3 && $page === 'return')
                <th>
                    <div class="flex">
                        <form action="{{ route('return.accept', ['id' => $employee->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success m-1" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Aceitar</button>
                        </form>
                        <form action="{{ route('return.recuse', ['id' => $employee->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-dark m-1" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Recusar</button>
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
        {{ $employees->links() }}
    </div>
</div>