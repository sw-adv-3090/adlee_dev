<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>

    <!-- CSS & JS Assets -->
    @vite(['resources/css/website.css', 'resources/js/website.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <script>
        /**
         * THIS SCRIPT REQUIRED FOR PREVENT FLICKERING IN SOME BROWSERS
         */
        localStorage.getItem("_x_darkMode_on") === "true" &&
            document.documentElement.classList.add("dark");
    </script>

    @isset($head)
    {{ $head }}
    @endisset

</head>

<body>
    <!-- Page Wrapper -->
    <div id="root" class="min-h-100vh flex flex-col bg-slate-50 dark:bg-navy-900">

        <header
            class="relative flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-3 dark:bg-neutral-800">
            <nav class="max-w-[75rem] w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between">
                <div class="flex items-center justify-between">
                    <a class="flex-none text-xl font-semibold dark:text-white focus:outline-none focus:opacity-80"
                        href="{{ route('homepage') }}" aria-label="Brand">
                        <img src="{{ asset('images/ADLEE-LOGO-1-1024x239.png') }}" alt="{{ config('app.name') }}"
                            class="w-32 sm:w-56 h-12 sm:h-20 object-contain">
                    </a>
                    <div class="sm:hidden">
                        <button type="button"
                            class="hs-collapse-toggle relative size-7 flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10"
                            id="hs-navbar-example-collapse" aria-expanded="false" aria-controls="hs-navbar-example"
                            aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-example">
                            <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="3" x2="21" y1="6" y2="6" />
                                <line x1="3" x2="21" y1="12" y2="12" />
                                <line x1="3" x2="21" y1="18" y2="18" />
                            </svg>
                            <svg class="hs-collapse-open:block hidden shrink-0 size-4"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M18 6 6 18" />
                                <path d="m6 6 12 12" />
                            </svg>
                            <span class="sr-only">Toggle navigation</span>
                        </button>
                    </div>
                </div>
                <div id="hs-navbar-example"
                    class="hidden hs-collapse overflow-hidden transition-all duration-300 basis-full grow sm:block"
                    aria-labelledby="hs-navbar-example-collapse">
                    <div class="flex flex-col gap-5 mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:ps-5">
                        <div class="hs-dropdown [--strategy:static] sm:[--strategy:fixed] [--adaptive:none] ">
                            <button id="hs-navbar-example-dropdown" type="button"
                                class="hs-dropdown-toggle flex items-center w-full text-gray-800 hover:text-gray-900 focus:outline-none focus:text-gray-900 font-normal dark:text-neutral-400 dark:hover:text-neutral-500 dark:focus:text-neutral-500 text-base"
                                aria-haspopup="menu" aria-expanded="false" aria-label="Mega Menu">
                                Login
                                <svg class="hs-dropdown-open:-rotate-180 sm:hs-dropdown-open:rotate-0 duration-300 ms-1 shrink-0 size-4"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div class="hs-dropdown-menu transition-[opacity,margin] ease-in-out duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 sm:w-48 z-10 bg-white sm:shadow-md rounded-lg p-1 space-y-1 dark:bg-neutral-800 sm:dark:border dark:border-neutral-700 dark:divide-neutral-700 before:absolute top-full sm:border before:-top-5 before:start-0 before:w-full before:h-5 hidden"
                                role="menu" aria-orientation="vertical" aria-labelledby="hs-navbar-example-dropdown">
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                    href="{{ route('login') }}">
                                    Sponsor
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                    href="{{ route('login') }}">
                                    Ad Space Owner
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                    href="{{ route('login') }}">
                                    Designer
                                </a>
                            </div>
                        </div>
                        <div class="hs-dropdown [--strategy:static] sm:[--strategy:fixed] [--adaptive:none] ">
                            <button id="hs-navbar-example-dropdown" type="button"
                                class="hs-dropdown-toggle flex items-center w-full text-gray-800 hover:text-gray-900 focus:outline-none focus:text-gray-900 font-normal dark:text-neutral-400 dark:hover:text-neutral-500 dark:focus:text-neutral-500 text-base"
                                aria-haspopup="menu" aria-expanded="false" aria-label="Mega Menu">
                                Memberships
                                <svg class="hs-dropdown-open:-rotate-180 sm:hs-dropdown-open:rotate-0 duration-300 ms-1 shrink-0 size-4"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div class="hs-dropdown-menu transition-[opacity,margin] ease-in-out duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 sm:w-48 z-10 bg-white sm:shadow-md rounded-lg p-1 space-y-1 dark:bg-neutral-800 sm:dark:border dark:border-neutral-700 dark:divide-neutral-700 before:absolute top-full sm:border before:-top-5 before:start-0 before:w-full before:h-5 hidden"
                                role="menu" aria-orientation="vertical"
                                aria-labelledby="hs-navbar-example-dropdown">
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                    href="#">
                                    Sponsor
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                    href="{{ route('pricing') }}">
                                    Pricing
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                    href="#">
                                    Ad Space Owners
                                </a>
                            </div>
                        </div>
                        <a class="font-normal text-gray-800 hover:text-gray-900 focus:outline-none focus:text-gray-900 dark:text-neutral-400 dark:hover:text-neutral-500 dark:focus:text-neutral-500 text-base"
                            href="https://technologysuite.tapfiliate.com/">Sign Up – Affiliates</a>
                        <a class="font-normal text-gray-800 hover:text-gray-900 focus:outline-none focus:text-gray-900 dark:text-neutral-400 dark:hover:text-neutral-500 dark:focus:text-neutral-500 text-base"
                            href="{{ route('register', ['type' => 'designer']) }}">Sign Up – Designers</a>
                    </div>
                </div>
            </nav>
        </header>

        <main class="py-10 flex-grow">
            {{ $slot }}
        </main>

        <footer class="w-full bg-white text-sm py-0 sm:py-3 dark:bg-neutral-800 mt-auto">
            <div class="max-w-[75rem] w-full mx-auto px-4">
                <div class="flex flex-col sm:flex-row items-center sm:justify-between pb-1 sm:pb-0">
                    <a class="flex-none text-xl font-semibold dark:text-white focus:outline-none focus:opacity-80"
                        href="{{ route('homepage') }}" aria-label="Brand">
                        <img src="{{ asset('images/ADLEE-LOGO-1-1024x239.png') }}" alt="{{ config('app.name') }}"
                            class="w-32 sm:w-56 h-16 object-contain">
                    </a>
                    <p>{{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
    <div id="x-teleport-target"></div>

    @isset($script)
    {{ $script }}
    @endisset
    @stack('scripts')

    @livewireScriptConfig
</body>

</html>