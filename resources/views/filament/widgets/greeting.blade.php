<x-filament::widget>
    @if (auth()->user()->group)
        <h1 class="text-2xl font-semibold mb-2 text-center">Hello {{ auth()->user()->name }} from {{ auth()->user()->group->name }} 🤘</h1>
    @elseif (auth()->user()->is_admin)
        <h1 class="text-2xl font-semibold mb-2 text-center">Hello {{ auth()->user()->name }} you are POWERFULL! 🔥</h1>
    @else
        <h1 class="text-2xl font-semibold mb-2 text-center">Hello {{ auth()->user()->name }} you don't seem to be part of any group 🤔</h1>
    @endif
</x-filament::widget>