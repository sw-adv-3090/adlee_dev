<div class="col-span-12">
    <div class="mb-5 flex items-center justify-center gap-5">
        <label class="relative flex">
            <input x-init="$el._x_flatpickr = flatpickr($el)"
                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="Start Date" type="text" wire:model.live="start" />
            <span
                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </span>
        </label>
        <label class="relative flex">
            <input x-init="$el._x_flatpickr = flatpickr($el)"
                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="End Date" type="text" wire:model.live="end" />
            <span
                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </span>
        </label>
    </div>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4">
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between space-x-1">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    ${{ $paymentProcessed }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-5 text-success"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                    <path
                        d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                    <path
                        d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Payment Processed</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between space-x-1">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    ${{ $commission }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-primary dark:text-accent" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Commission</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between space-x-1">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    ${{ $stripeFee }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-5 text-primary dark:text-accent"
                    viewBox="0 0 16 16">
                    <path
                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.226 5.385c-.584 0-.937.164-.937.593 0 .468.607.674 1.36.93 1.228.415 2.844.963 2.851 2.993C11.5 11.868 9.924 13 7.63 13a7.7 7.7 0 0 1-3.009-.626V9.758c.926.506 2.095.88 3.01.88.617 0 1.058-.165 1.058-.671 0-.518-.658-.755-1.453-1.041C6.026 8.49 4.5 7.94 4.5 6.11 4.5 4.165 5.988 3 8.226 3a7.3 7.3 0 0 1 2.734.505v2.583c-.838-.45-1.896-.703-2.734-.703" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Stripe Fee</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $sponsors }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-info" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Sponsors</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $adSpaceOwners }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-error" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Ad Space Owners</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between space-x-1">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $booklets }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-secondary" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Total Booklets</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between space-x-1">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $tickets }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-warning" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path
                        d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zM1.5 4a.5.5 0 0 0-.5.5v1.05a2.5 2.5 0 0 1 0 4.9v1.05a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-1.05a2.5 2.5 0 0 1 0-4.9V4.5a.5.5 0 0 0-.5-.5z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Total Tickets</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between space-x-1">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $freeBooklets }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-success" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path
                        d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1z" />
                    <path
                        d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Free Booklets</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between space-x-1">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $ticketsPrinted }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-error" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                    <path
                        d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Ticket's Printed</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $ticketsPaid }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-success" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Ticket's Paid</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $ticketsPartialPaid }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-warning" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Ticket's Partial Paid</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $ticketsPaymentFailed }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-5 text-error"
                    viewBox="0 0 16 16">
                    <path
                        d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708" />
                    <path
                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Ticket's Payment Failed</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $ticketsRedeemed }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-success" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Ticket's Redeemed</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $ticketsRedeemedPending }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-warning" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Ticket's Pending for Redeem</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $ticketsActivationPending }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-5 text-info"
                    viewBox="0 0 16 16">
                    <path
                        d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Ticket's Pending for Activation</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $ticketsPendingSigned }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-5 text-warning"
                    viewBox="0 0 16 16">
                    <path
                        d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702s.18.149.5.149.5-.15.5-.15v-.7c0-.701.478-1.236 1.011-1.492A3.5 3.5 0 0 0 11.5 3V2z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Ticket's Pending for Signed</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $ticketsPendingPrinting }}
                </p>

                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-5 text-info"
                    viewBox="0 0 16 16">
                    <path
                        d="M2 14.5a.5.5 0 0 0 .5.5h11a.5.5 0 1 0 0-1h-1v-1a4.5 4.5 0 0 0-2.557-4.06c-.29-.139-.443-.377-.443-.59v-.7c0-.213.154-.451.443-.59A4.5 4.5 0 0 0 12.5 3V2h1a.5.5 0 0 0 0-1h-11a.5.5 0 0 0 0 1h1v1a4.5 4.5 0 0 0 2.557 4.06c.29.139.443.377.443.59v.7c0 .213-.154.451-.443.59A4.5 4.5 0 0 0 3.5 13v1h-1a.5.5 0 0 0-.5.5m2.5-.5v-1a3.5 3.5 0 0 1 1.989-3.158c.533-.256 1.011-.79 1.011-1.491v-.702s.18.101.5.101.5-.1.5-.1v.7c0 .701.478 1.236 1.011 1.492A3.5 3.5 0 0 1 11.5 13v1z" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Ticket's Pending for Printing</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $ticketsActive }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-5 text-success"
                    viewBox="0 0 16 16">
                    <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8" />
                    <path
                        d="M9.653 5.496A3 3 0 0 0 8 5c-.61 0-1.179.183-1.653.496L4.694 2.992A5.97 5.97 0 0 1 8 2c1.222 0 2.358.365 3.306.992zm1.342 2.324a3 3 0 0 1-.884 2.312 3 3 0 0 1-.769.552l1.342 2.683c.57-.286 1.09-.66 1.538-1.103a6 6 0 0 0 1.767-4.624zm-5.679 5.548 1.342-2.684A3 3 0 0 1 5.005 7.82l-2.994-.18a6 6 0 0 0 3.306 5.728ZM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Active Tasks</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $sponsorCancellation }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-5 text-warning"
                    viewBox="0 0 16 16">
                    <path
                        d="M13.879 10.414a2.501 2.501 0 0 0-3.465 3.465zm.707.707-3.465 3.465a2.501 2.501 0 0 0 3.465-3.465m-4.56-1.096a3.5 3.5 0 1 1 4.949 4.95 3.5 3.5 0 0 1-4.95-4.95ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Sponsor Cancellation</p>
        </div>
        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
            <div class="flex justify-between">
                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                    {{ $adSpaceOwnerCancellation }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-5 text-error"
                    viewBox="0 0 16 16">
                    <path
                        d="M13.879 10.414a2.501 2.501 0 0 0-3.465 3.465zm.707.707-3.465 3.465a2.501 2.501 0 0 0 3.465-3.465m-4.56-1.096a3.5 3.5 0 1 1 4.949 4.95 3.5 3.5 0 0 1-4.95-4.95ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
                </svg>
            </div>
            <p class="mt-1 text-xs+">Ad Space Owner Cancellation</p>
        </div>
    </div>
</div>
