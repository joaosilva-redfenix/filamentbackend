<x-filament::widget>
    <x-filament::card class="bg-white rounded-lg shadow-md p-4">
        <h3 class="text-lg font-semibold mb-2 text-center">Hello {{ auth()->user()->name }} from {{ auth()->user()->group->name }}</h3>
    </x-filament::card>
</x-filament::widget>
