<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            @if ($affiliates != null)
                {{ __('Atualizar Afiliado') }}
            @else
                {{ __('Criar Afiliados') }}
            @endif
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            @if ($affiliates != null)
                {{ __('Aviso atualize afiliado') }}
            @else
                {{ __('Aviso criar afiliados') }}
            @endif
        </p>
    </header>

    <form method="POST"
        action="{{ $affiliates ? route('affiliate.update', $affiliates->id) : route('affiliate.store') }}">
        @csrf
        @if ($affiliates)
            @method('PATCH')
        @endif

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                value="{{ $affiliates ? $affiliates->name : old('name') }}" required autocomplete />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                value="{{ $affiliates ? $affiliates->email : old('email') }}" required autocomplete />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>



        @if ($affiliates)
            <!-- Reset Password Switch -->
            <label class="inline-flex items-center mt-4 cursor-pointer">
                <input id="reset_password" name="reset_password" type="checkbox" value="reset_password"
                    class="sr-only peer">
                <div
                    class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none  rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                </div>
                <span for="reset_password" class="ms-3 text-sm font-medium text-black-900 dark:text-black-300">Reset
                    Senha </span>
            </label>
        @endif

        <div class="flex items-center gap-4 mt-4">
            <x-primary-button>{{ $affiliates ? __('Atualizar Afiliado') : __('Criar Afiliado') }}</x-primary-button>
        </div>
    </form>
</section>
