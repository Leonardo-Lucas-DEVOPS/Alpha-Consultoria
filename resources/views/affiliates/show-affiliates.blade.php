<x-app-layout>
    @if (session('success'))
        <div class="alert alert-success mb-1">
            {{ session('success') }}
        </div>
    @endif
    @if (session('alert'))
        <div class="alert alert-warning mb-1">
            {{ session('alert') }}
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7x2 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-x2">
                    @include('affiliates.partials.affiliates-list')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
