

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>


    <div class="bg-blue-700 border border-gray-800 rounded shadow p-2">
        @foreach ($chunkedFields as $fields)


        <div class="items-center">
            <p class="rounded-sm py-1 text-center text-2xl text-white"></p>
            <div class="flex justify-center bg-gray-100 py-10 p-14">
                @foreach ($fields as $label => $fieldPropertyOrLabel)
                @if(is_array($fieldPropertyOrLabel))
                    @php
                        $modelFieldType = $fieldPropertyOrLabel['type'];
                        $field = $fieldPropertyOrLabel['field'];
                    @endphp
                    @switch($modelFieldType)
                        @case("related.agregate")

                        <div class="container">
                            <div class="w-72 h-25 bg-white max-w-xs mx-auto rounded-md overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 transform hover:scale-100 cursor-pointer">
                            <div class="bg-green-600 flex items-center justify-between">
                                <p class="mr-0 text-white text-lg pl-2"></p>
                            </div>
                            <div class="flex justify-between px-1 mb-1 text-sm text-gray-600">

                            </div>
                            {{$model->callFunctionFromRelatedCollection($field["relation" ],$field["function"])}}}}
                            </div>
                        </div>
                            @break
                    @endswitch
                @else
                <div class="container">
                    <div class="w-72 h-25 bg-white max-w-xs mx-auto rounded-md overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 transform hover:scale-100 cursor-pointer">
                    <div class="bg-green-600 flex items-center justify-between">
                        <p class="mr-0 text-white text-lg pl-2">{{$label}}</p>
                    </div>
                    <div class="flex justify-between px-1 mb-1 text-sm text-gray-600">

                    </div>
                    {{$model->$fieldPropertyOrLabel}}
                    </div>
                </div>
                @endif

                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{$slot}}

