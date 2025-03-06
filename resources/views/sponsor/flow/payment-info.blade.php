<x-layouts.app-layout title="Payment Information" is-header-blur="true">

    <div class="flex items-center space-x-4 py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Payment Information
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <x-sponsor-flow-steps :step3="true" :step4="true" :step5="true" />

        <div class="col-span-12 grid lg:col-span-9">
            <div class="grid place-items-center">
                <div class="card w-full max-w-xl p-4 sm:p-5" x-data="pages.initCreditCard">
                    <div
                        class="relative mx-auto -mt-20 h-40 w-72 rounded-lg text-white shadow-xl transition-transform hover:scale-110 lg:h-48 lg:w-80">
                        <div class="h-full w-full rounded-lg" :class="creditCardUI"></div>
                        <div class="absolute top-0 flex h-full w-full flex-col justify-between p-4 sm:p-5">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-xs+ font-light">Name</p>
                                    <p class="font-medium uppercase tracking-wide" x-text="nameOnCard"></p>
                                </div>
                                <template x-if="cardLogoSrc">
                                    <img src="null" :src="cardLogoSrc" class="w-12 rounded-lg"
                                        alt="creditcard" />
                                </template>
                            </div>
                            <div class="pt-4">
                                <p class="text-xs+ font-light">Card Number</p>
                                <p class="font-medium tracking-wide" x-text="cardNumber"></p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-4">
                        <p class="text-xl font-semibold text-primary dark:text-accent-light" x-text="cardText"></p>
                        <div
                            class="badge rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                            Primary
                        </div>
                    </div>
                    <div class="space-y-4">
                        <label class="block">
                            <span>Card number</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="**** **** **** ****" type="text" x-model.debounce="cardNumber"
                                x-input-mask="creditCardInput" />
                        </label>
                        <label class="block">
                            <span>Name on card</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="John Doe" type="text" x-model.debounce="nameOnCard" />
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="block">
                                <span>Expiration date</span>
                                <input
                                    class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                    placeholder="mm/yy" type="text"
                                    x-input-mask="{ date: true, datePattern: ['m', 'y'] }" />
                            </label>
                            <label class="block">
                                <span>CVV</span>
                                <input
                                    class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                    placeholder="***" type="password" x-input-mask="{ numeral: true }" maxlength="3" />
                            </label>
                        </div>
                        <div class="flex justify-center space-x-2 pt-4">
                            <button
                                class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app-layout>
