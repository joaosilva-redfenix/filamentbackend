<x-filament::widget>

        <h1 class="text-2xl font-semibold mb-2 text-center">Hello {{ auth()->user()->name }} from {{ auth()->user()->group->name }} 🤘</h1>

</x-filament::widget>
