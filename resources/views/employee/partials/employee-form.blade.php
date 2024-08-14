<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Formulário de Consulta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Aviso Formulário') }}
        </p>
    </header>

    <form class="mt-5f  space-y-6"
        action="{{ $employee ? route('employee.update', $employee->id) : route('employee.store') }}" method="POST">
        @csrf
        @if ($employee)
            @method('PATCH')
        @endif

        <div>
            <x-input-label for="nome" :value="__('Nome do funcionário')" />
            <x-text-input value="{{ $employee ? $employee->name : old('name') }}" id="name" name="name"
                type="text" class="mt-1 block w-full" autocomplete required />
        </div>
        <div>
            <x-input-label for="rg" :value="__('RG do funcionário   ')" />
            <x-text-input value="{{ $employee ? $employee->rg : old('rg') }}" id="rg" name="rg"
                type="text" class="mt-1 block w-full" autocomplete placeholder="Apenas digitos" required />

        </div>
        <div>
            <x-input-label for="cpf" :value="__('CPF do funcionário')" />
            <x-text-input value="{{ $employee ? $employee->cpf : old('cpf') }}" id="cpf" name="cpf"
                type="text" class="mt-1 block w-full" autocomplete placeholder="Apenas digitos" required />

        </div>
        <div>
            <x-input-label for="mae" :value="__('Nome da mãe do funcionário')" />
            <x-text-input value="{{ $employee ? $employee->mae : old('mae') }}" id="mae" name="mae"
                type="text" class="mt-1 block w-full" autocomplete required />

        </div>
        <div>
            <x-input-label for="pai" :value="__('Nome do pai do funcionário')" />
            <x-text-input value="{{ $employee ? $employee->pai : old('pai') }}" id="pai" name="pai"
                type="text" class="mt-1 block w-full" autocomplete />

        </div>
        <div>
            <x-input-label for="nascimento" :value="__('Data do nascimento do funcionário')" />
            <x-text-input value="{{ $employee ? $employee->nascimento : old('nascimento') }}" id="nascimento"
                name="nascimento" type="date" class="mt-1 block w-full" autocomplete required />

        </div>
        <div>
            <x-text-input id="user_id" name="user_id" type="hidden" class="mt-1 block w-full"
                autocomplete />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
