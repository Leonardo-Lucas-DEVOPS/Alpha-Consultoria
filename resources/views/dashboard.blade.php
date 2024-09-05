<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('fail'))
                <div class="alert alert-danger mb-3">
                    {{ session('fail') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container p-6 text-gray-900">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                            <!-- Cartões usuário comum -->
                            <div class="card" style="width: 100%;">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card">
                                <div class="card-body">
                                    <h5 class="card-title">Consulta de funcionário</h5>
                                    <p class="card-text">Serviço de consulta criminal e processual, estadual e
                                        municipal, e antecedentes criminais de pessoas.</p>
                                </div>
                                <div class="m-2 mt-0">
                                    <a href="{{ Route('employee.create') }}" class="btn btn-dark">Consultar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                            <div class="card" style="width: 100%;">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card">
                                <div class="card-body">
                                    <h5 class="card-title">Consulta de prestadores de serviço</h5>
                                    <p class="card-text">Consulta criminal e processual, status de CNH e veículo de
                                        prestadores.</p>
                                </div>
                                <div class="m-2 mt-0">
                                    <a href="{{ Route('freelancer.create') }}" class="btn btn-dark">Consultar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                            <div class="card" style="width: 100%;">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card">
                                <div class="card-body">
                                    <h5 class="card-title">Consulta de veículo</h5>
                                    <p class="card-text">Consulta de Débitos e Restrições, Regularidade Documental,
                                        Situação Judicial, Informações Técnicas.</p>
                                </div>
                                <div class="m-2 mt-0">
                                    <a href="{{ Route('vehicle.create') }}" class="btn btn-dark">Consultar</a>
                                </div>
                            </div>
                        </div>

                        <!-- Cartões Admin -->
                        @if (Auth::user()->usertype >= 1)
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                                <div class="card" style="width: 100%;">
                                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card">
                                    <div class="card-body">
                                        <h5 class="card-title">Gerenciar funcionário</h5>
                                        <p class="card-text">Editar consulta ou deletar solicitação.</p>
                                    </div>
                                    <div class="m-2 mt-0">
                                        <a href="{{ route('employee.show') }}" class="btn btn-dark">Consultar</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                                <div class="card" style="width: 100%;">
                                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card">
                                    <div class="card-body">
                                        <h5 class="card-title">Gerenciar prestadores de serviço</h5>
                                        <p class="card-text">Editar consulta ou deletar solicitação.</p>
                                    </div>
                                    <div class="m-2 mt-0">
                                        <a href="{{ route('freelancer.show') }}" class="btn btn-dark">Consultar</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                                <div class="card" style="width: 100%;">
                                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card">
                                    <div class="card-body">
                                        <h5 class="card-title">Gerenciar veículo</h5>
                                        <p class="card-text">Editar consulta ou deletar solicitação.</p>
                                    </div>
                                    <div class="m-2 mt-0">
                                        <a href="{{ route('vehicle.show') }}" class="btn btn-dark">Consultar</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Cartões SUPER Admin -->
                        @if (Auth::user()->usertype >= 3)
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                                <div class="card" style="width: 100%;">
                                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card">
                                    <div class="card-body">
                                        <h5 class="card-title">Consulta de funcionário</h5>
                                        <p class="card-text">Serviço de consulta criminal e processual, estadual e
                                            municipal, e antecedentes criminais de pessoas.</p>
                                    </div>
                                    <div class="m-2 mt-0">
                                        <a href="#" class="btn btn-dark">Consultar</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                                <div class="card" style="width: 100%;">
                                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card">
                                    <div class="card-body">
                                        <h5 class="card-title">Consulta de prestadores de serviço</h5>
                                        <p class="card-text">Consulta criminal e processual, status de CNH e veículo de
                                            prestadores.</p>
                                    </div>
                                    <div class="m-2 mt-0">
                                        <a href="{{route('affiliate.show')}}" class="btn btn-dark">Consultar</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                                <div class="card" style="width: 100%;">
                                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card">
                                    <div class="card-body">
                                        <h5 class="card-title">Consulta de veículo</h5>
                                        <p class="card-text">Consulta de Débitos e Restrições, Regularidade Documental,
                                            Situação Judicial, Informações Técnicas.</p>
                                    </div>
                                    <div class="m-2 mt-0">
                                        <a href="{{ route('affiliate.create') }}" class="btn btn-dark">Consultar</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
