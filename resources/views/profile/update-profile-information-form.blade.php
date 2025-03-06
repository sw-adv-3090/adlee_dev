<x-layouts.app-layout title="Profile Update" is-header-blur="true">
    <x-breadcrumbs title="Account" menu="Profile" />

    <div class="flex flex-col lg:flex-row gap-4 sm:gap-5 lg:gap-6">
        @include('profile.sidebar')

        <div class="w-full lg:w-[67%]">
            <div class="card">

                <form action="{{ route('profile.account.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ __('Account Setting') }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <x-primary-button class="min-w-[7rem] rounded-full">
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        @session('status')
                            <div class="mt-2 mb-5 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ $value }}
                            </div>
                        @endsession
                        <x-validation-errors class="mb-4" />

                        <div class="flex flex-col">
                            <span class="text-base font-medium text-slate-600 dark:text-navy-100">Avatar</span>
                            <div class="avatar mt-1.5 size-20">
                                <img id="avatar" class="mask is-squircle" src="{{ auth()->user()->avatar }}"
                                    alt="{{ auth()->user()->name }}" />
                                <div
                                    class="absolute bottom-0 right-0 flex items-center justify-center rounded-full bg-white dark:bg-navy-700">
                                    <input type="file" id="profilePhoto" name="profile_photo" class="hidden">
                                    <label for="profilePhoto"
                                        class="btn size-6 rounded-full border border-slate-200 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:border-navy-500 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span>Full Name </span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Enter full name" type="text" name="name"
                                        value="{{ auth()->user()->name }}" />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-user text-base"></i>
                                    </span>
                                </span>
                            </label>
                            <label class="block">
                                <span>Email Address </span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Enter email address" type="email" name="email"
                                        value="{{ auth()->user()->email }}" />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-envelope text-base"></i>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        const profilePhoto = document.getElementById("profilePhoto");

        profilePhoto.addEventListener("change", function(event) {
            const file = event.target.files[0];

            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = (e) => document.getElementById("avatar").src = e.target.result;
        });
    </script>
</x-layouts.app-layout>
