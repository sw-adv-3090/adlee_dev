<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8">
    <div class="col-span-12 grid lg:col-span-8">
        <div class="card p-4 sm:p-5">
            <h3 class="text-base font-medium text-slate-800 dark:text-navy-50 lg:text-lg mb-3">Create Shipment</h3>
            <form action="{{ route('admin.jobs.booklet-prints.shipment', $job) }}" method="post">
                @csrf
                <div class="mt-4 space-y-5">
                    {{-- select carrier --}}
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Carrier</span>
                        <select
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            name="carrier_id" wire:model.live="carrier_id" required>
                            <option value="">Select Carrier</option>
                            @foreach ($carriers as $carrier)
                                <option value="{{ $carrier['carrier_id'] }}" @selected(old('carrier_id') === $carrier['carrier_id'])>
                                    {{ $carrier['name'] }}</option>
                            @endforeach

                        </select>
                    </label>
                    @error('carrier_id')
                        <span class="text-xs text-error">{{ $message }}</span>
                    @enderror

                    {{-- select carrier services --}}
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Carrier Services</span>
                        <select
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            name="service_code" required @disabled(empty($services))>
                            <option value="">Select Carrier Service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service['service_code'] }}" @selected(old('service_code') === $service['service_code'])>
                                    {{ $service['name'] }}</option>
                            @endforeach

                        </select>
                    </label>
                    @error('service_code')
                        <span class="text-xs text-error">{{ $message }}</span>
                    @enderror


                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Package Weight (In Pounds)</span>
                        <span class="relative mt-1.5 flex">
                            <input
                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2  placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="Package Weight" type="number" name="weight" value="{{ old('weight') }}"
                                required />
                        </span>
                    </label>
                    @error('weight')
                        <span class="text-xs text-error">{{ $message }}</span>
                    @enderror

                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Package Length (In Inches)</span>
                        <span class="relative mt-1.5 flex">
                            <input
                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2  placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="Package Length" type="number" name="length" value="{{ old('length') }}"
                                required />
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
                                placeholder="Package Width" type="number" name="width" value="{{ old('width') }}"
                                required />
                        </span>
                    </label>
                    @error('width')
                        <span class="text-xs text-error">{{ $message }}</span>
                    @enderror

                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Package Height (In Inches)</span>
                        <span class="relative mt-1.5 flex">
                            <input
                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2  placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="Package Height" type="number" name="height" value="{{ old('height') }}"
                                required />
                        </span>
                    </label>
                    @error('height')
                        <span class="text-xs text-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-center mt-8">
                    <button type="submit"
                        class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Create Shipment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
