<x-admin-layout :title="'Pengaturan - Panel Kurator'">

    <div class="space-y-6">

        @include('admin.partials.flash')

        {{-- Header --}}
        <section class="flex flex-col justify-between gap-5 md:flex-row md:items-end">

            <div>
                <p class="mb-2 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-[0.14em] text-[#FB4D00]">
                    Panel Kurator
                </p>

                <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-[-0.04em] text-[#49261D] sm:text-4xl">
                    Pengaturan
                </h1>

                <p class="mt-2 max-w-2xl text-sm text-[#796B65]">
                    Kelola identitas platform, kebijakan moderasi, dan akun kurator Interlude.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#E9DCD4] bg-white px-3.5 py-2 text-xs font-bold text-[#49261D] shadow-sm">
                    <i class="fa-solid fa-sliders text-[#FB4D00]"></i>
                    {{ count($groups) }} Grup Pengaturan
                </span>

                <span class="inline-flex items-center gap-2 rounded-full border border-[#E9DCD4] bg-white px-3.5 py-2 text-xs font-bold text-[#49261D] shadow-sm">
                    <i class="fa-regular fa-envelope text-[#FB4D00]"></i>
                    {{ $values['contact_email'] ?? 'halo@interlude.id' }}
                </span>
            </div>

        </section>

        {{-- Platform Settings --}}
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            @foreach($groups as $group)
                <section class="rounded-2xl border border-[#E9DCD4] bg-white p-5 shadow-sm sm:p-6">

                    <div class="flex items-start gap-3 border-b border-[#E9DCD4]/70 pb-4">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#FFEDE3] text-[#FB4D00]">
                            <i class="{{ $group['icon'] }}"></i>
                        </span>

                        <div>
                            <h2 class="font-['Plus_Jakarta_Sans'] text-base font-extrabold text-[#49261D]">
                                {{ $group['title'] }}
                            </h2>
                            <p class="mt-0.5 text-xs text-[#796B65]">
                                {{ $group['description'] }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-5 md:grid-cols-2">
                        @foreach($group['fields'] as $key => $field)
                            @php
                                $type = $field['type'] ?? 'text';
                                $value = old($key, $values[$key] ?? $field['default'] ?? null);
                                $hasError = $errors->has($key);
                            @endphp

                            @if($type === 'boolean')
                                <div class="md:col-span-2">
                                    <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-[#E9DCD4] bg-[#FFFAF6] p-4 transition hover:border-[#FB4D00]/60">
                                        <input type="hidden" name="{{ $key }}" value="0">
                                        <input
                                            type="checkbox"
                                            name="{{ $key }}"
                                            value="1"
                                            @checked(filter_var($value, FILTER_VALIDATE_BOOLEAN))
                                            class="mt-0.5 h-5 w-5 rounded border-[#E9DCD4] text-[#FB4D00] focus:ring-[#FB4D00]"
                                        >
                                        <span>
                                            <span class="block font-['Plus_Jakarta_Sans'] text-sm font-bold text-[#49261D]">
                                                {{ $field['label'] }}
                                            </span>
                                            @if(! empty($field['help']))
                                                <span class="mt-0.5 block text-[11px] text-[#796B65]">
                                                    {{ $field['help'] }}
                                                </span>
                                            @endif
                                        </span>
                                    </label>
                                </div>
                            @else
                                @include('admin.partials.setting-field', [
                                    'key' => $key,
                                    'field' => $field,
                                    'value' => $value,
                                    'type' => $type,
                                    'hasError' => $hasError,
                                ])
                            @endif
                        @endforeach
                    </div>

                </section>
            @endforeach

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-full bg-[#49261D] px-6 py-3 text-xs font-bold text-white transition hover:bg-[#FB4D00]"
                >
                    <i class="fa-solid fa-floppy-disk text-[10px]"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>

        {{-- Account Settings --}}
        <form method="POST" action="{{ route('admin.settings.account') }}" class="rounded-2xl border border-[#E9DCD4] bg-white p-5 shadow-sm sm:p-6">
            @csrf
            @method('PUT')

            <div class="flex items-start gap-3 border-b border-[#E9DCD4]/70 pb-4">
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#CAE7F7] text-[#17333F]">
                    <i class="fa-solid fa-user-shield"></i>
                </span>

                <div>
                    <h2 class="font-['Plus_Jakarta_Sans'] text-base font-extrabold text-[#49261D]">
                        Akun Kurator
                    </h2>
                    <p class="mt-0.5 text-xs text-[#796B65]">
                        Perbarui identitas dan kata sandi akun kurator yang sedang aktif.
                    </p>
                </div>
            </div>

            @php $admin = auth('admin')->user(); @endphp

            <div class="mt-5 grid gap-5 md:grid-cols-2">

                <div>
                    <label for="name" class="mb-1.5 block text-xs font-bold text-[#49261D]">Nama Kurator</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $admin->name) }}"
                        class="w-full rounded-2xl border bg-[#FFFAF6] px-4 py-3 text-sm text-[#49261D] focus:bg-white focus:outline-none focus:ring-1 {{ $errors->has('name') ? 'border-[#E4572E] focus:border-[#E4572E] focus:ring-[#E4572E]' : 'border-[#E9DCD4] focus:border-[#FB4D00] focus:ring-[#FB4D00]' }}"
                    >
                    @error('name')
                        <span class="mt-1.5 block text-[11px] font-bold text-[#A93100]">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-xs font-bold text-[#49261D]">Email Kurator</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $admin->email) }}"
                        class="w-full rounded-2xl border bg-[#FFFAF6] px-4 py-3 text-sm text-[#49261D] focus:bg-white focus:outline-none focus:ring-1 {{ $errors->has('email') ? 'border-[#E4572E] focus:border-[#E4572E] focus:ring-[#E4572E]' : 'border-[#E9DCD4] focus:border-[#FB4D00] focus:ring-[#FB4D00]' }}"
                    >
                    @error('email')
                        <span class="mt-1.5 block text-[11px] font-bold text-[#A93100]">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-xs font-bold text-[#49261D]">Kata Sandi Baru</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        placeholder="Kosongkan bila tidak diubah"
                        class="w-full rounded-2xl border bg-[#FFFAF6] px-4 py-3 text-sm text-[#49261D] placeholder-[#796B65]/60 focus:bg-white focus:outline-none focus:ring-1 {{ $errors->has('password') ? 'border-[#E4572E] focus:border-[#E4572E] focus:ring-[#E4572E]' : 'border-[#E9DCD4] focus:border-[#FB4D00] focus:ring-[#FB4D00]' }}"
                    >
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-xs font-bold text-[#49261D]">Ulangi Kata Sandi Baru</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="w-full rounded-2xl border border-[#E9DCD4] bg-[#FFFAF6] px-4 py-3 text-sm text-[#49261D] placeholder-[#796B65]/60 focus:border-[#FB4D00] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#FB4D00]"
                    >
                    @error('password')
                        <span class="mt-1.5 block text-[11px] font-bold text-[#A93100]">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="mt-5 flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-full border border-[#49261D] bg-white px-6 py-3 text-xs font-bold text-[#49261D] transition hover:bg-[#49261D] hover:text-white"
                >
                    <i class="fa-solid fa-user-pen text-[10px]"></i>
                    Perbarui Akun
                </button>
            </div>
        </form>

    </div>

</x-admin-layout>