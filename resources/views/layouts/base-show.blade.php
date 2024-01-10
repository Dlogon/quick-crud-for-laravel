<x-quick-crud-for-laravel-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-3 gap-4 text-center">
            <div class="flow-root">
                @if (isset($previousRecord))
                    <a class="float-left" href="{{ route($routeNamme, $previousRecord) }}" title="Registro anterior">
                        <x-quick-crud-for-laravel::primary-button class="bg-blue-400">
                            <x-quick-crud-for-laravel::icons.previous-button />
                        </x-quick-crud-for-laravel::primary-button>
                    </a>
                @endif
            </div>
            <div>{{ $header }}</div>
            <div class="flow-root">
                @if (isset($nextRecord))
                    <a class="float-right" href="{{ route($routeNamme, $nextRecord) }}" title="Siguiente registro" >
                        <x-quick-crud-for-laravel::primary-button type="button" class="bg-blue-400">
                            <x-quick-crud-for-laravel::icons.next-button />
                        </x-quick-crud-for-laravel::primary-button>
                    </a>
                @endif
            </div>
        </div>
    </x-slot>
    {{ $slot }}
</x-quick-crud-for-laravel-app-layout>
