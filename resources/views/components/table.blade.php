<div class="p-4">
    <div class="overflow-x-auto">
        <div class="flex flex-wrap px-1 mx-auto">
        @foreach ($searchFields as $name => $data)
            <div class="w-50 md:w-50 m-1 px-2 py-2 border border-gray-600">
            @switch($data["type"])
                @case("related")
                @php
                    $elemets = $data['elements'];
                    $modelDisplay = $data["modelDisplay"];
                    $selectValue = $data["value"];
                @endphp
                <label for="">{{$data['label'] ?? ""}}</label>
                <select data-type="related" name="{{$name}}" id="{{$name}}" class="search">
                    <option>Seleccione</option>
                    @foreach ($elemets as $k=>$v)
                        <option value="{{$v->$selectValue}}">
                            {{$v->$modelDisplay}}
                        </option>
                    @endforeach
                </select>
                @break
                @case("singleDate")
                    <label for="">{{$data['label'] ?? ""}}</label>
                    <input type="date" placeholder="dd-mm-yyyy" min="2010-01-01"  data-type="single-date" data-field="{{$name}}"  name="{{$name}}" class="search">
                @break
                @case("fromToDate")
                {{-- //TODO Code this --}}
                    {{-- <label for="">{{$data['label'] ?? ""}}</label>
                    Desde<input  data-type="date" data-field="{{$name}}" type="date" name="from{{$name}}" class="search">
                    Hasta<input  data-type="date" data-field="{{$name}}" type="date" name="to{{$name}}" class="search to-date-field"> --}}
                @break
                @default
                <label for="">{{$data['placeholder'] ?? ""}}</label>
                <input placeholder="{{$data['placeholder'] ?? ""}}" data-type="text" type="text" name="{{$name}}" class="search">
            @endswitch
            </div>
        @endforeach
        </div>
        <table class="table-auto w-full">
            <thead class="text-sm font-semibold uppercase text-gray-800 bg-gray-300 divide-y divide-x">
                <tr>
                    @foreach ($fields as $label => $field)
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">{{ $label }}</div>
                        </th>
                    @endforeach
                    @if($actions)
                    <th class="p-2 whitespace-nowrap">
                        <div class="font-semibold text-left">Acciones</div>
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-sm divide-gray-300">
                @foreach ($models as $model)
                    <tr>
                        @foreach ($fields as $label => $fieldPropertyOrLabel)

                            @if(is_array($fieldPropertyOrLabel))
                                @php
                                    $modelFieldType = $fieldPropertyOrLabel['type'];
                                    $field = $fieldPropertyOrLabel['field'];
                                @endphp
                                @switch($modelFieldType)
                                    @case("related")
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-left">{{ $model->getRelatedModelProperty($field) }}</div>
                                    </td>
                                        @break
                                    @case("money")
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-left">{{money_format($model->$field)}}</div>
                                    </td>
                                    @break
                                    @default
                                @endswitch
                            @else
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-left">{{ $model->$fieldPropertyOrLabel }}</div>
                            </td>
                            @endif
                        @endforeach
                        @if($actions)
                        <td class="p-2 whitespace-nowrap">

                            @if ($showButton)
                                <x-quick-crud-for-laravel::show-button route="{{ route($route . '.show', $model->id) }}"></x-quick-crud-for-laravel::show-button>
                            @endif
                            @if ($editButton)
                                <x-quick-crud-for-laravel::edit-button route="{{ route($route . '.edit', $model->id) }}"></x-quick-crud-for-laravel::edit-button>
                            @endif
                            @if ($deleteButton)
                                <x-quick-crud-for-laravel::primary-button data-model-id="{{ $model->id }}"
                                    data-delete-route="{{ route($route . '.destroy', $model->id) }}"
                                    class="delete-button modal-open bg-red-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 25 25"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </x-quick-crud-for-laravel::primary-button>
                            @endif
                            @foreach ($modelActions as $componentName => $attrOrComp)
                                @if(is_array($attrOrComp))
                                    <x-dynamic-component :component="$componentName" :model="$model" :attr="$attrOrComp"/>
                                @else
                                    <x-dynamic-component :component="$attrOrComp" :model="$model" />
                                @endif
                            @endforeach
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                {{$slot}}
            </tfoot>
        </table>
        @if ($paginate && !$isSearch)
            {{ $models->links() ?? "" }}
        @endif

    </div>
</div>

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", buildFilters);

        function buildFilters() {

            setInputsFromQueryStringSearch();
            let elements = document.querySelectorAll(".search");
            for (let i of elements) {
                i.addEventListener("change", searchByQueryParamsOnChange)
            }

        }

        function setInputsFromQueryStringSearch() {
        let searchqs = getQueryStringObject("q");
        for (var key in searchqs) {
            let searchObj = JSON.parse(searchqs[key]);
            let value = searchObj.value;
            document.getElementsByName(key)[0].value = value;
        }
        return searchqs;
    }

        function searchByQueryParamsOnChange(el)
        {
            debugger;
            let element = el.currentTarget;
            let searchValue = element.value;
            let searchKey = element.name;
            let querystring = "";
            let currentSearchQuery = getQueryStringObject("q");
            let type = element.dataset.type;

            // if ($(this).hasClass("customSeach") || false) {
            //     let customCallback = $(this).data("customcallback");
            //     searchCustom = searchCustom.filter(function(el) {
            //         return el.key != searchKey;
            //     });
            //     if (searchValue && searchValue != 0)
            //         searchCustom.push({
            //             customCallback,
            //             key: searchKey,
            //             data: searchValue
            //         });
            // } else
            {
                delete currentSearchQuery[searchKey];
                if (searchValue && searchValue != 0)
                    currentSearchQuery[searchKey] = searchValue;
            }

            for (var key in currentSearchQuery)
            {
                querystring += "q[" + key + "]=" + currentSearchQuery[key] + "&";
            }
            let searchObj = {
                    type,
                    value : searchValue
                }
            querystring += "q[" + searchKey + "]=" + JSON.stringify(searchObj) + "&";


            // if (searchCustom.length)
            //     querystring += "q[customCallback]=" + JSON.stringify({
            //         callbacks: searchCustom
            //     }) + "&";

            querystring.slice(0, -1);
            const module = window.location.pathname;
            if (querystring)
                window.location.href += "/search?" + querystring;
            else
                window.location.href += "/" + module;
        }
    </script>
@endpush
