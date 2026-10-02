{{-- Flash Notification --}}
@if(session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        class="flex items-center justify-between rounded-2xl border border-[#DDF3E4] bg-[#EDF9F1] px-5 py-4 text-[#18794E] shadow-sm"
    >
        <div class="flex items-center gap-3">
            <span class="grid h-8 w-8 place-items-center rounded-full bg-[#DDF3E4] text-[#18794E]">
                <i class="fa-solid fa-check text-sm"></i>
            </span>
            <p class="font-['Plus_Jakarta_Sans'] text-xs font-bold sm:text-sm">
                {{ session('success') }}
            </p>
        </div>
        <button
            type="button"
            @click="show = false"
            class="text-[#18794E]/70 hover:text-[#18794E]"
        >
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="rounded-2xl border border-[#FFD0C3] bg-[#FFF0EC] px-5 py-4 text-[#9A2A0E] shadow-sm">
        <div class="flex items-center gap-3">
            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-[#FFE0D8] text-[#A93100]">
                <i class="fa-solid fa-triangle-exclamation text-sm"></i>
            </span>
            <p class="font-['Plus_Jakarta_Sans'] text-xs font-bold sm:text-sm">
                Periksa kembali data yang kamu isi.
            </p>
        </div>

        <ul class="mt-3 list-disc space-y-1 pl-14 text-xs">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif