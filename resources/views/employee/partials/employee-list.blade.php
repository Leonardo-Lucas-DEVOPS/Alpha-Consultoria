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
                <th class="px-4 py-2">Consultor</th>
                <th class="px-4 py-2">Criado em</th>
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
                    <td class="px-4 py-2">{{ $employee->user_id }}</td>
                    <td class="px-4 py-2">{{ $employee->created_at }}</td>
                    <td class="px-4 py-2">{{ $employee->return_status }}</td>
                    @if (Auth::user()->usertype == 2)
                        <td>
                            <div class="flex space-x-2">
                                <form action="{{ route('employee.edit', $employee->id) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Alterar</button>
                                </form>
                                <form action="{{ route('employee.destroy', $employee->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            </div>
                        </td>
                        @if (Auth::user()->usertype == 3)
                            <td>
                                <div class="flex flex-col space-y-2">
                                    <form action="{{ route('employee.accept', $employee->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm w-full">Aprovado</button>
                                    </form>
                                    <form action="{{ route('employee.reject', $employee->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-dark btn-sm w-full">Recusado</button>
                                    </form>
                                    <form action="{{ route('employee.destroy', $employee->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-full">Deletar</button>
                                    </form>
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
        {{ $employees->links() }}
    </div>
</div>
