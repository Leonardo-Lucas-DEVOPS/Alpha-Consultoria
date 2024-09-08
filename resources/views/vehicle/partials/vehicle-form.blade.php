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
        action="{{ $vehicle ? route('vehicle.update', $vehicle->id) : route('vehicle.store') }}" method="POST">
        @csrf
        @if ($vehicle)
            @method('PATCH')
        @endif


        <div>
            <x-input-label for="placa" :value="__('Placa do veículo')" />
            <x-text-input value="{{ $vehicle ? $vehicle->placa : old('placa') }}" id="placa" name="placa"
                type="text" class="mt-1 block w-full" autocomplete required />
        </div>
        <div>
            <x-input-label for="chassi" :value="__('Chassi do veículo')" />
            <x-text-input value="{{ $vehicle ? $vehicle->chassi : old('chassi') }}" id="chassi" name="chassi"
                type="text" class="mt-1 block w-full" autocomplete placeholder="Apenas digitos" required />

        </div>
        <div>
            <x-input-label for="renavam" :value="__('Renavam do veículo')" />
            <x-text-input value="{{ $vehicle ? $vehicle->renavam : old('renavam') }}" id="renavam" name="renavam"
                type="text" class="mt-1 block w-full" autocomplete placeholder="Apenas digitos" required />

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
