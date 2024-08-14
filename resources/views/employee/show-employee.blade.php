<x-app-layout>
    <div class="py-12">
        <div class="max-w-7x2 mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-x2">
                    @include('employee.partials.employee-list')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @include('employee.partials.employee-audit')
            </div>
        </div>
    </div>
</x-app-layout>
