<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Formulário de Consulta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Aviso Formulário') }}
        </p>
    </header>

    <form class="mt-5 space-y-6"
        action="{{ $freelancer ? route('freelancer.update', $freelancer->id) : route('freelancer.store') }}"
        method="POST">
        @csrf
        @if ($freelancer)
            @method('PATCH')
        @endif

        <div>
            <x-input-label for="name" :value="__('Nome do prestador')" />
            <x-text-input value="{{ $freelancer ? $freelancer->name : old('name') }}" id="name" name="name"
                type="text" class="mt-1 block w-full" autocomplete required />
        </div>
        <div>
            <x-input-label for="rg" :value="__('RG do prestador   ')" />
            <x-text-input value="{{ $freelancer ? $freelancer->rg : old('rg') }}" id="rg" name="rg"
                type="text" class="mt-1 block w-full" autocomplete placeholder="Apenas digitos" required />
        </div>
        <div>
            <x-input-label for="cpf" :value="__('CPF do prestador')" />
            <x-text-input value="{{ $freelancer ? $freelancer->cpf : old('cpf') }}" id="cpf" name="cpf"
                type="text" class="mt-1 block w-full" autocomplete placeholder="Apenas digitos" required />
        </div>
        <div>
            <x-input-label for="mae" :value="__('Nome da mãe do prestador')" />
            <x-text-input value="{{ $freelancer ? $freelancer->mae : old('mae') }}" id="mae" name="mae"
                type="text" class="mt-1 block w-full" autocomplete required />
        </div>
        <div>
            <x-input-label for="pai" :value="__('Nome do pai do prestador')" />
            <x-text-input value="{{ $freelancer ? $freelancer->pai : old('pai') }}" id="pai" name="pai"
                type="text" class="mt-1 block w-full" autocomplete />
        </div>
        <div>
            <x-input-label for="nascimento" :value="__('Data do nascimento do prestador')" />
            <x-text-input value="{{ $freelancer ? $freelancer->nascimento : old('nascimento') }}" id="nascimento"
                name="nascimento" type="date" class="mt-1 block w-full" autocomplete required />
        </div>
        <div>
            <x-input-label for="cnh" :value="__('CNH do prestador')" />
            <x-text-input value="{{ $freelancer ? $freelancer->cnh : old('cnh') }}" id="cnh" name="cnh"
                type="text" class="mt-1 block w-full" autocomplete />
        </div>
        <div>
            <x-input-label for="placa" :value="__('Placa do veículo do prestador')" />
            <x-text-input value="{{ $freelancer ? $freelancer->placa : old('placa') }}" id="placa" name="placa"
                type="text" class="mt-1 block w-full" autocomplete />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
