<x-layouts.app-layout title="Booklet Shipment" is-sidebar-open="true">
    <div
        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Booklet Shipment
        </h2>

        <a href="{{ route('admin.jobs.booklet-prints') }}"
            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
            </svg>
            <span> Back </span>
        </a>
    </div>

    @include('partials.alert')

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8">
        <div class="col-span-12 grid lg:col-span-8">
            <div class="card p-4 sm:p-5">
                <h3 class="text-base font-medium text-slate-800 dark:text-navy-50 lg:text-lg mb-3">Job Details</h3>
                <div
                    class="is-scrollbar-hidden min-w-full overflow-x-auto rounded-lg border border-slate-200 dark:border-navy-500">
                    <table class="w-full text-left">
                        <tbody>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Booklet Title
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $job->booklet?->title }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Booklet Number
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $job->booklet?->number }}
                                </td>
                            </tr>

                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Coupons
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $job->booklet?->coupons?->count() ?? 0 }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    @if ($job->shipment)
        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8">
            <div class="col-span-12 grid lg:col-span-8">
                <div class="card p-4 sm:p-5">
                    <h3 class="text-base font-medium text-slate-800 dark:text-navy-50 lg:text-lg mb-3">Shipment Details
                    </h3>
                    <div
                        class="is-scrollbar-hidden min-w-full overflow-x-auto rounded-lg border border-slate-200 dark:border-navy-500">
                        <table class="w-full text-left">
                            <tbody>
                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Tracking Number
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        {{ $job->shipment->tracking_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Tracking Status
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5 capitalize">
                                        {{ str_replace('_', ' ', $job->shipment->tracking_status) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Tracking URL
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        <a href="{{ $job->shipment->tracking_url }}" class="text-xs text-primary"
                                            target="_blank">{{ $job->shipment->tracking_url }}</a>
                                    </td>
                                </tr>

                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Shipping Date
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        {{ $job->shipment->ship_date->format('F j, Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Created At
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        {{ $job->shipment->created_at->format('F j, Y h:i:A') }}
                                    </td>
                                </tr>
                                <tr>

                                    <td class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5"
                                        colspan="2">
                                        <div class="flex items-center gap-2 flex-wrap justify-center">
                                            <a href="{{ $job->shipment->download_pdf }}"
                                                class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                                                download>
                                                <span> Download PDF </span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    fill="currentColor" class="bi bi-file-earmark-arrow-down"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                                                    <path
                                                        d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                                </svg>
                                            </a>
                                            <a href="{{ $job->shipment->download_png }}"
                                                class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                                                download>
                                                <span> Download PNG </span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                                    <path
                                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                                </svg>
                                            </a>
                                            <a href="{{ $job->shipment->download_zpl }}"
                                                class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                                                download>
                                                <span> Download ZPL </span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    fill="currentColor" class="bi bi-cloud-download"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383" />
                                                    <path
                                                        d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    @else
        @livewire('admin.jobs.booklet-shipment', ['job' => $job, 'items' => $carriers])
    @endif


</x-layouts.app-layout>
