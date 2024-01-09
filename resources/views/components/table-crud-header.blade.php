<h2 class="font-semibold text-xl text-gray-600 leading-tight flow-root" >
    <div class="float-left">
        {{ __($header) }}
        {{$slot}}
    </div>



    <div class="float-right">

        <x-quick-crud-for-laravel::primary-button type="button" class="bg-green-600">
            <a href="{{route($createRoute)}}">
            {{ __($creteButtonText) }}
            </a>
        </x-quick-crud-for-laravel::primary-button>
    </div>
</h2>
