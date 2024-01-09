<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-500">
            <x-dlogon-quickcrud-navigation></x-dlogon-quickcrud-navigation>
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-slate-200 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main id="app">
                {{ $slot }}
            </main>
            <div class="tailwindAlert">
                <x-tailwindalerts::tailwind-alert />
            </div>
                {{-- DELETEMODAL --}}

    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

            <div
                class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                    viewBox="0 0 18 18">
                    <path
                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                    </path>
                </svg>
                <span class="text-sm">(Esc)</span>
            </div>

            <!-- Add margin if you want to see some of the overlay behind the modal-->
            <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold"></p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!--Body-->
                <form method="POST" action="" id="modal-form-delete">
                    @method('DELETE')
                    @csrf
                    <div id="modalBody">

                    </div>

                    <!--Footer-->
                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">Borrar</button>
                        <button type="button"
                            class="modal-close px-4 bg-blue-500 p-3 rounded-lg text-white hover:bg-indigo-400">Cerrar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- DELETEMODAL --}}
        </div>
    </body>

    <script>
        document.addEventListener("DOMContentLoaded", initModal);
        document.addEventListener("DOMContentLoaded", setModalDeleteData);


        function setModalDeleteData() {
            let elements = document.querySelectorAll(".delete-button");
            for (let i of elements) {
                i.addEventListener("click", (e) => {

                    let button = e.currentTarget;
                    let modelId = button.dataset.modelId;
                    let modelName = button.dataset.modelName;
                    let deleteRoute = button.dataset.deleteRoute;

                    var deleteModalForm = document.getElementById("modal-form-delete");
                    deleteModalForm.action = deleteRoute;
                    deleteModalForm.querySelector("#modalBody").innerHTML =
                        "Seguro que desea eliminar el registro " + modelId
                })
            }
        }

        function initModal() {
            var openmodal = document.querySelectorAll('.modal-open')
            for (var i = 0; i < openmodal.length; i++) {
                openmodal[i].addEventListener('click', function(event) {
                    event.preventDefault()
                    toggleModal()
                })
            }

            const overlay = document.querySelector('.modal-overlay')
            overlay.addEventListener('click', toggleModal)

            var closemodal = document.querySelectorAll('.modal-close')
            for (var i = 0; i < closemodal.length; i++) {
                closemodal[i].addEventListener('click', toggleModal)
            }

            document.onkeydown = function(evt) {
                evt = evt || window.event
                var isEscape = false
                if ("key" in evt) {
                    isEscape = (evt.key === "Escape" || evt.key === "Esc")
                } else {
                    isEscape = (evt.keyCode === 27)
                }
                if (isEscape && document.body.classList.contains('modal-active')) {
                    toggleModal()
                }
            };
        }



        function toggleModal() {
            const body = document.querySelector('body')
            const modal = document.querySelector('.modal')
            modal.classList.toggle('opacity-0')
            modal.classList.toggle('pointer-events-none')
            body.classList.toggle('modal-active')
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", setInputsFromQueryString);

        function randomString(len = 16)
        {
            return (Math.random() + 1).toString(36).substring(len);
        }

        function getQueryStringObject(entry = "inputs") {
            const urlParams = new URLSearchParams(window.location.search);
            const entries = urlParams.entries();
            const entryName = entry
            return ArrayparamsToObject(entries, entryName);
        }

        function setInputsFromQueryString() {
            let searchqs = getQueryStringObject()
            for (var key in searchqs) {
                document.getElementsByName(key)[0].value = searchqs[key]
            }
            return searchqs;
        }

        function createInputQueryString(field, value) {
            return "inputs[" + field + "]=" + value + "&";
        }

        function createInputsFromQueryString(inputs) {
            var querystring = "";
            for (var key in inputs)
                querystring += createInputQueryString(key, inputs[key]);
        }

        function ArrayparamsToObject(entries, name) {
            let result = []
            var reg = new RegExp(name + '(\\[(?<key>.*)\\])', "g");
            for (let entry of entries) {
                var reg = new RegExp(name + '(\\[(?<key>.*)\\])', "g");
                let data = entry[0];
                let key = reg.exec(data);
                if (!key)
                    continue;
                key = key.groups.key
                let value = entry[1];
                result[key] = value;
            }
            return result;
        }
    </script>
    @stack('js')
</html>
