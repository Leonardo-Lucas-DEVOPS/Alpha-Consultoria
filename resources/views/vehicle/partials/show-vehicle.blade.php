<x-app-layout>
    <div class="py-12">
        <div class="max-w-7x2 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-x2">
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
                                    @if (Auth::user()->usertype >= 2)
                                    <th>
                                        <div class="flex">
                                            
                                            <button class="btn btn-primary mr-1" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" href="">Editar</button>
                                            <button class="btn btn-danger ml-1 " style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" href="">Excluir</button>
                                        </div>
                                    </th>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>