<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Formulário de Consulta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Aviso Formulário") }}
        </p>
    </header>


    <form method="post" action="{{ route('vehicle.store') }}" class="mt-5f  space-y-6">
        @csrf


        <div>
            <x-input-label for="placa" :value="__('Placa do veículo')" />
            <x-text-input id="placa" name="placa" type="text" class="mt-1 block w-full" autocomplete="placa" required />
        </div>
        <div>
            <x-input-label for="chassi" :value="__('Chassi do veículo')" />
            <x-text-input id="chassi" name="chassi" type="text" class="mt-1 block w-full" autocomplete="chassi" placeholder="Apenas digitos" required />

        </div>
        <div>
            <x-input-label for="renavam" :value="__('Renavam do veículo')" />
            <x-text-input id="renavam" name="renavam" type="text" class="mt-1 block w-full" autocomplete="renavam" placeholder="Apenas digitos" required />

        </div>
        <div>
            <x-text-input id="user_id" name="user_id" type="hidden" class="mt-1 block w-full" autocomplete="user_id" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>

</section>