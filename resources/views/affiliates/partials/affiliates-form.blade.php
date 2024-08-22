<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Formulario Afiliados') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Aviso afiliados') }}
        </p>
    </header>



    <form method="POST" action="{{ route('affiliate.store') }}">
        @csrf

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autocomplete />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
       
    
        <div class="flex items-center gap-4 mt-4">
            <x-primary-button>{{ __('Criar Afiliado') }}</x-primary-button>
        </div>

    </form>
</section>