<div class="{{ $type === 'textarea' ? 'md:col-span-2' : '' }}">
    <label for="{{ $key }}" class="mb-1.5 block text-xs font-bold text-[#49261D]">
        {{ $field['label'] }}
    </label>

    @if($type === 'textarea')
        <textarea
            id="{{ $key }}"
            name="{{ $key }}"
            rows="3"
            class="w-full rounded-2xl border bg-[#FFFAF6] px-4 py-3 text-sm text-[#49261D] placeholder-[#796B65]/60 focus:bg-white focus:outline-none focus:ring-1 {{ $hasError ? 'border-[#E4572E] focus:border-[#E4572E] focus:ring-[#E4572E]' : 'border-[#E9DCD4] focus:border-[#FB4D00] focus:ring-[#FB4D00]' }}"
        >{{ $value }}</textarea>
    @else
        <input
            id="{{ $key }}"
            type="{{ $type }}"
            name="{{ $key }}"
            value="{{ $value }}"
            class="w-full rounded-2xl border bg-[#FFFAF6] px-4 py-3 text-sm text-[#49261D] placeholder-[#796B65]/60 focus:bg-white focus:outline-none focus:ring-1 {{ $hasError ? 'border-[#E4572E] focus:border-[#E4572E] focus:ring-[#E4572E]' : 'border-[#E9DCD4] focus:border-[#FB4D00] focus:ring-[#FB4D00]' }}"
        >
    @endif

    @if(! empty($field['help']))
        <span class="mt-1.5 block text-[11px] text-[#796B65]">
            {{ $field['help'] }}
        </span>
    @endif

    @error($key)
        <span class="mt-1.5 block text-[11px] font-bold text-[#A93100]">
            {{ $message }}
        </span>
    @enderror
</div>