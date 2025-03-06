<x-layouts.app-layout title="Shipment Carrier Information" is-sidebar-open="true">
    <div
        class="mt-6 flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left">
        <div class="flex items-center space-x-1">
            <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                Shipment Carrier Informations
            </h2>
        </div>
    </div>

    @include('partials.alert')

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8">
        <div class="col-span-12 grid lg:col-span-8">
            <div class="card p-4 sm:p-5">
                <div class="">
                    <h3 class="font-medium text-slate-600 dark:text-navy-100 text-lg">Shipment Carrier</h3>
                    <p class="my-1.5">Write down shipment carrier details including print booklet packet information.
                        This information will be used for automatically creating booklet print label using ShipEngine
                        whenever sponsor requested for print booklet.
                    </p>
                </div>
                <form action="{{ route('admin.settings.shipment.carrier.update') }}" method="post">
                    @csrf

                    @livewire('carrier', ['items' => $carriers])

                    <div class="space-y-5 mt-4">

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Package Weight (In
                                Pounds)</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2  placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Package Weight" type="number" name="weight"
                                    value="{{ old('weight', settings('weight')) }}" required />
                            </span>
                        </label>
                        @error('weight')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Package Length (In
                                Inches)</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2  placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Package Length" type="number" name="length"
                                    value="{{ old('length', settings('length')) }}" required />
                            </span>
                        </label>
                        @error('length')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Package Width (In Inches)</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2  placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Package Width" type="number" name="width"
                                    value="{{ old('width', settings('width')) }}" required />
                            </span>
                        </label>
                        @error('width')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Package Height (In
                                Inches)</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2  placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Package Height" type="number" name="height"
                                    value="{{ old('height', settings('height')) }}" required />
                            </span>
                        </label>
                        @error('height')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-center mt-8">
                        <button type="submit"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            Save
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-layouts.app-layout>
