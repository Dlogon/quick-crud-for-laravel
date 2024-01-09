<nav class="bg-slate-100 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->


                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="route('dashboard')">
                        {{ __('Dashboard') }}
                    </a>
                </div>
                @foreach ($indexRoutes as $index)
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{route($index)}}">
                        {{$index}}
                    </a>
                </div>
                @endforeach

            </div>
</nav>
