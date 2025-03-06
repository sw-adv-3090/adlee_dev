<div class="mt-6">
    <div class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left">
        {{-- <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Send Coupon
        </h2> --}}

        <div class="flex items-center gap-5">
            @php
                $outline =
                    'btn border border-primary font-medium text-primary hover:bg-primary hover:text-white focus:bg-primary focus:text-white active:bg-primary/90 dark:border-accent dark:text-accent-light dark:hover:bg-accent dark:hover:text-white dark:focus:bg-accent dark:focus:text-white dark:active:bg-accent/90';
                $active =
                    'btn border border-primary font-medium bg-primary text-white focus:bg-primary focus:text-white active:bg-primary/90 dark:border-accent dark:text-accent-light dark:bg-accent  dark:focus:bg-accent dark:focus:text-white dark:active:bg-accent/90';
            @endphp
            <button class="{{ $type === 'register' ? $active : $outline }}" wire:click="changeType('register')">
                Registered BBO's
            </button>

            <button class="{{ $type === 'email' ? $active : $outline }}" wire:click="changeType('email')">
                Send by Email
            </button>
        </div>

        <a href="{{ coupon_return_url($coupon) }}"
            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
            </svg>
            <span> Back </span>
        </a>
    </div>

    @if ($type === 'register')
        <div class="flex items-center justify-between py-5 lg:py-6 mt-2">
            <div class="flex items-center space-x-1">
                <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                    Ad Space Owners / BBO's
                </h2>
            </div>

            <div class="flex items-center space-x-2">
                <label class="relative hidden sm:flex">
                    <input
                        class="form-input peer h-9 w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 text-xs+ placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Search here..." type="text" wire:model.live.debounce.250ms="search" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 transition-colors duration-200"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                        </svg>
                    </span>
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6 xl:grid-cols-4">
            @forelse ($users as $user)
                <div class="card">
                    <div class="flex flex-col items-center p-4 text-center sm:p-5">
                        <div class="avatar size-20">
                            <img class="rounded-full " src="{{ $user->avatar }}" alt=" {{ $user->name }}" />
                        </div>
                        <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                            {{ $user->name }}
                        </h3>
                        <p class="text-xs+">{{ $user->email }}</p>
                        <div class="my-4 h-px w-full bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grow space-y-4">
                            {{-- <div class="flex items-center space-x-4">
                                <div
                                    class="flex size-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                                    <i class="fa fa-phone text-xs"></i>
                                </div>
                                <p>(01) 22 888 4444</p>
                            </div> --}}
                            <div class="flex items-center space-x-4">
                                <div
                                    class="flex size-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                                    <i class="fa fa-envelope text-xs"></i>
                                </div>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div
                                    class="flex size-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                                    <i class="fa fa-tasks text-xs"></i>
                                </div>
                                <p>{{ $user->tickets_count }} completed tasks</p>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('sponsors.coupons.send.store', $coupon) }}" method="post"
                        class="flex divide-x divide-slate-150 border-t border-slate-150 dark:divide-navy-500 dark:border-navy-500">
                        @csrf
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <button type="submit"
                            class="btn h-11 w-full rounded-none rounded-b-lg font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                            Send Coupon
                        </button>
                    </form>
                </div>
            @empty
                <div
                    class="alert col-span-12 rounded-lg border border-primary px-4 py-4 text-primary dark:border-accent dark:text-accent-light sm:px-5">
                    No user found
                </div>
            @endforelse

        </div>
    @else
        <div class="card p-4 sm:p-5 mt-8">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Send Coupon to Email
                </h2>
            </div>
            <div class="max-w-3xl">
                <p>
                    We will send coupon to given email and your friend will received coupon through email and he has to
                    register with Adlee to redeem the coupon.
                </p>
                <div class="mt-5">
                    <form action="{{ route('sponsors.coupons.send.store', $coupon) }}" method="post">
                        @csrf
                        <div class="space-y-5">
                            <label class="block">
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Email Address" name="email" type="email" required />
                            </label>
                            @error('email')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror

                            <button type="submit"
                                class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                Send Coupon
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    @endif
</div>
