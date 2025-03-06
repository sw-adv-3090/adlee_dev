<x-layouts.website-layout>
    <div class="max-w-4xl mx-auto w-full py-6">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 sm:gap-5 lg:gap-6">
            @foreach ($plans as $plan)
                @php
                    $isBasic = str_contains(strtolower($plan->name), 'basic');
                    $isCurrentPlan = false;
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
                            class="fa {{ $isBasic ? 'fa-car' : 'fa-plane' }}  text-6xl text-[#07277c] dark:text-accent-light"></i>
                    </div>
                    <div class="mt-5">
                        <h4 class="text-xl font-semibold text-[#07277c] dark:text-navy-100">
                            {{ $plan->name }}
                        </h4>
                    </div>
                    <div class="mt-5">
                        <span
                            class="text-4xl tracking-tight text-[#07277c] dark:text-accent-light">${{ $plan->price }}</span>/month
                    </div>
                    <div class="mt-8 space-y-4 text-left">
                        <div class="flex items-start space-x-3">
                            <div
                                class="flex size-6 shrink-0 items-center justify-center rounded-full bg-[#07277c]/10 text-[#07277c] dark:bg-accent/10 dark:text-accent-light">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-normal text-gray-700 dark:text-navy-100"> Access to
                                {{ $isBasic ? $plan->template_limit : 'Unlimited' }}
                                templates from each
                                category</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="flex size-6 shrink-0 items-center justify-center rounded-full bg-[#07277c]/10 text-[#07277c] dark:bg-accent/10 dark:text-accent-light">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-normal text-gray-700 dark:text-navy-100">
                                {{ $plan->ach_transaction_fee }}% for ACH
                                transactions</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="flex size-6 shrink-0 items-center justify-center rounded-full bg-[#07277c]/10 text-[#07277c] dark:bg-accent/10 dark:text-accent-light">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-normal text-gray-700 dark:text-navy-100">
                                {{ $plan->credit_card_transaction_fee }}% for
                                Credit Card
                                transactions</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="flex size-6 shrink-0 items-center justify-center rounded-full bg-[#07277c]/10 text-[#07277c] dark:bg-accent/10 dark:text-accent-light">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-normal text-gray-700 dark:text-navy-100">
                                {{ $plan->transaction_service_fee }}% transaction
                                service
                                fee</span>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="flex size-6 shrink-0 items-center justify-center rounded-full bg-[#07277c]/10 text-[#07277c] dark:bg-accent/10 dark:text-accent-light">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-normal text-gray-700 dark:text-navy-100"> Coupon booklets of
                                {{ $plan->booklet_pages }} will
                                be
                                ${{ $plan->booklet_fee }}</span>
                        </div>
                        @if ($isBasic)
                            <div class="flex items-start space-x-3">
                                <div
                                    class="flex size-6 shrink-0 items-center justify-center rounded-full bg-warning/10 text-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-normal text-gray-700 dark:text-navy-100"> {{ $plan->free_booklets }}
                                    Coupon booklets
                                    free</span>
                            </div>
                        @else
                            <div class="flex items-start space-x-3">
                                <div
                                    class="flex size-6 shrink-0 items-center justify-center rounded-full bg-[#07277c]/10 text-[#07277c] dark:bg-accent/10 dark:text-accent-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="font-normal text-gray-700 dark:text-navy-100"> {{ $plan->free_booklets }}
                                    Coupon booklets
                                    free (worth
                                    ${{ $plan->booklet_fee }})</span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('login') }}"
                            class="btn rounded-full border border-slate-200 font-medium text-[#07277c] hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-500 dark:text-accent-light dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90 ">
                            Choose Plan
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.website-layout>
