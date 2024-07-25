<section>


    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Formulário de Funcionário') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Aviso Formulário de Funcionário") }}
        </p>
    </header>

    
    <form method="post" action="{{ route('employee.store') }}" class="mt-5f  space-y-6">
        @csrf


        <div>
            <x-input-label for="nome" :value="__('Nome do funcionário')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" autocomplete="name" />

        </div>
        <div>
            <x-input-label for="rg" :value="__('RG do funcionário   ')" />
            <x-text-input id="rg" name="rg" type="text" class="mt-1 block w-full" autocomplete="rg" />

        </div>
        <div>
            <x-input-label for="cpf" :value="__('CPF do funcionário')" />
            <x-text-input id="cpf" name="cpf" type="text" class="mt-1 block w-full" autocomplete="cpf" />

        </div>
        <div>
            <x-input-label for="mae" :value="__('Nome da mãe do funcionário')" />
            <x-text-input id="mae" name="mae" type="text" class="mt-1 block w-full" autocomplete="mae" />

        </div>
        <div>
            <x-input-label for="pai" :value="__('Nome do pai do funcionário')" />
            <x-text-input id="pai" name="pai" type="text" class="mt-1 block w-full" autocomplete="pai" />

        </div>
        <div>
            <x-input-label for="nascimento" :value="__('Data do nascimento do funcionário')" />
            <x-text-input id="nascimento" name="nascimento" type="date" class="mt-1 block w-full" autocomplete="nascimento" />

        </div>
        <div>
            <x-text-input id="user_id" name="user_id" type="hidden" class="mt-1 block w-full" autocomplete="user_id" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
    
</section>