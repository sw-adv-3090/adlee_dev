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
                <option value="{{ $service['service_code'] }}" @selected(old('service_code', settings('service_code')) === $service['service_code'])>
                    {{ $service['name'] }}</option>
            @endforeach

        </select>
    </label>
    @error('service_code')
        <span class="text-xs text-error">{{ $message }}</span>
    @enderror
</div>
