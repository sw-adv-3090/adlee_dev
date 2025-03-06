<x-layouts.app-layout title="Choose Plan" is-header-blur="true">

    <div class="flex items-center space-x-4 py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Choose Subscription Plan
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <x-ad-space-owner-flow-steps :step3="true" :step4="true" :step5="true" />

        <div class="col-span-12 grid lg:col-span-9">
            <div class="grid max-w-4xl grid-cols-1 gap-4 lg:grid-cols-2 sm:gap-5 lg:gap-6">
                @foreach ($plans as $plan)
                    @php
                        $isBasic = str_contains(strtolower($plan->name), 'basic');
                        $isCurrentPlan = auth()->user()->plan()?->id == $plan->id;
                    @endphp
                    <div class="card p-4 text-center sm:p-5">
                        @if (!$isBasic)
                            <div class="absolute top-0 right-0 p-3">
                                <div class="badge rounded-full bg-info/10 text-info dark:bg-info/15">
                                    Recommended
                                </div>
                            </div>
                        @endif

                        <div class="mt-8">
                            <i
                                class="fa {{ $isBasic ? 'fa-car' : 'fa-plane' }}  text-6xl text-primary dark:text-accent-light"></i>
                        </div>
                        <div class="mt-5">
                            <h4 class="text-xl font-semibold text-slate-600 dark:text-navy-100">
                                {{ $plan->name }}
                            </h4>
                        </div>
                        <div class="mt-5">
                            <span
                                class="text-4xl tracking-tight text-primary dark:text-accent-light">${{ $plan->price }}</span>/month
                        </div>
                        <div class="mt-8 space-y-4 text-left">
                            <div class="flex items-start space-x-3">
                                <div
                                    class="flex size-6 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-medium"> Receive sponsorship money for events or advertisements</span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div
                                    class="flex size-6 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-medium"> Print out any approved template that was selected by the
                                    Sponsor
                                </span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div
                                    class="flex size-6 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-medium"> Scan QR codes on coupons or click virtual coupon link to
                                    claim coupons</span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div
                                    class="flex size-6 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-medium"> Adlee handles the invoicing for you</span>
                            </div>
                        </div>

                        <div class="mt-8">
                            <form action="{{ route('ad-space-owner.basic-settings.subscription-checkout') }}"
                                method="post">
                                @csrf
                                <input type="hidden" name="planId" value="{{ $plan->id }}">
                                <button type="submit"
                                    class="btn rounded-full border border-slate-200 font-medium text-primary hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-500 dark:text-accent-light dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90 {{ $isCurrentPlan ? 'text-white bg-primary' : '' }}"
                                    {{ $isCurrentPlan ? 'disabled' : '' }}>
                                    {{ $isCurrentPlan ? 'Current Plan' : 'Choose Plan' }}
                                </button>
                            </form>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</x-layouts.app-layout>
