<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Masuk — Interlude</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1"
        rel="stylesheet"
    >

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        chocolate: '#49261D',
                        'chocolate-dark': '#30120A',

                        botticelli: '#CAE7F7',
                        linen: '#FFEDE3',

                        tangelo: '#FB4D00',
                        'tangelo-dark': '#D44000',

                        cream: '#FFFAF6',

                        ink: '#1C1B19',
                        muted: '#6F605B',

                        soft: '#F8F3EF',
                        borderwarm: '#D5C2BE',
                        error: '#BA1A1A'
                    },

                    fontFamily: {
                        headline: ['Plus Jakarta Sans', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            font-family: 'DM Sans', sans-serif;

            background:
                radial-gradient(
                    circle at 12% 15%,
                    rgba(202, 231, 247, .55) 0%,
                    transparent 38%
                ),
                radial-gradient(
                    circle at 88% 82%,
                    rgba(255, 237, 227, .9) 0%,
                    transparent 37%
                ),
                #FFFAF6;
        }

        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 450,
                'GRAD' 0,
                'opsz' 24;
        }

        .auth-card {
            box-shadow:
                0 25px 70px rgba(73, 38, 29, .09),
                0 2px 8px rgba(73, 38, 29, .04);
        }

        .auth-input {
            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }

        .auth-input:focus {
            border-color: #FB4D00;
            background: #FFFFFF;

            box-shadow:
                0 0 0 4px rgba(251, 77, 0, .08);

            outline: none;
        }

        .auth-input.input-error {
            border-color: #BA1A1A;
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>


<body class="min-h-screen text-ink antialiased">

<div class="flex min-h-screen flex-col">


    <!-- =====================================================
         HEADER
    ====================================================== -->
    <header class="w-full px-5 pt-6 md:px-8 lg:px-12">

        <div
            class="mx-auto flex max-w-7xl items-center justify-between"
        >

            <!-- Back -->
            <a
                href="{{ url('/') }}"
                class="group inline-flex items-center gap-2 text-sm font-semibold text-muted transition hover:text-chocolate"
            >
                <span
                    class="material-symbols-outlined text-[20px] transition-transform group-hover:-translate-x-1"
                >
                    arrow_back
                </span>

                <span>Kembali</span>
            </a>


            <!-- Logo -->
            <a
                href="{{ url('/') }}"
                class="font-headline text-[23px] font-extrabold tracking-[-1px] text-chocolate"
            >
                Interlude<span class="text-tangelo">.</span>
            </a>


            <!-- Spacer -->
            <div class="hidden w-[74px] md:block"></div>

        </div>

    </header>



    <!-- =====================================================
         MAIN
    ====================================================== -->
    <main
        class="flex w-full flex-1 items-center justify-center px-5 py-10 md:px-8 lg:px-12"
    >

        <div class="w-full max-w-[460px]">


            <!-- ===============================
                 AUTH CARD
            ================================ -->
            <div
                class="auth-card rounded-[28px] border border-chocolate/5 bg-white p-6 sm:p-9"
            >


                <!-- Brand mark -->
                <div class="mb-7 flex flex-col items-center text-center">

                    <div
                        class="mb-5 flex h-11 w-11 items-center justify-center rounded-full bg-botticelli text-chocolate"
                    >
                        <span
                            class="material-symbols-outlined text-[23px]"
                        >
                            pause
                        </span>
                    </div>


                    <h1
                        class="font-headline text-[28px] font-extrabold tracking-[-.8px] text-chocolate"
                    >
                        Selamat datang kembali.
                    </h1>


                    <p
                        class="mt-2 max-w-[340px] text-sm leading-6 text-muted"
                    >
                        Lanjutkan membaca, mendengarkan,
                        dan berbagi cerita di Interlude.
                    </p>

                </div>



                <!-- ===============================
                     SESSION STATUS
                ================================ -->

                @if (session('status'))

                    <div
                        class="mb-5 rounded-2xl bg-botticelli/60 px-4 py-3 text-sm font-medium text-chocolate"
                    >
                        {{ session('status') }}
                    </div>

                @endif



                <!-- ===============================
                     GOOGLE BUTTON
                ================================ -->

                <button
                    type="button"
                    class="flex h-12 w-full items-center justify-center gap-3 rounded-2xl border border-chocolate/10 bg-soft px-4 text-sm font-bold text-chocolate transition hover:border-chocolate/15 hover:bg-linen active:scale-[.99]"
                >

                    <!-- Google icon -->
                    <svg
                        aria-hidden="true"
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                    >

                        <path
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            fill="#4285F4"
                        />

                        <path
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            fill="#34A853"
                        />

                        <path
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"
                            fill="#FBBC05"
                        />

                        <path
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"
                            fill="#EA4335"
                        />

                    </svg>

                    <span>
                        Lanjutkan dengan Google
                    </span>

                </button>



                <!-- ===============================
                     DIVIDER
                ================================ -->

                <div
                    class="relative my-7 flex items-center justify-center"
                >

                    <div
                        class="h-px w-full bg-chocolate/10"
                    ></div>

                    <span
                        class="absolute bg-white px-4 text-xs text-muted"
                    >
                        atau dengan email
                    </span>

                </div>



                <!-- ===============================
                     LOGIN FORM
                ================================ -->

                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="space-y-5"
                >

                    @csrf


                    <!-- ===========================
                         EMAIL
                    ============================ -->
                    <div>

                        <label
                            for="email"
                            class="mb-2 block font-headline text-[12px] font-bold tracking-[.02em] text-chocolate"
                        >
                            Email
                        </label>


                        <input
                            type="email"
                            id="email"
                            name="email"

                            value="{{ old('email') }}"

                            autocomplete="username"

                            placeholder="nama@email.com"

                            required
                            autofocus

                            class="
                                auth-input
                                h-12
                                w-full
                                rounded-2xl
                                border
                                bg-soft
                                px-4
                                text-sm
                                text-ink
                                placeholder:text-muted/50

                                @error('email')
                                    input-error
                                    border-error
                                @else
                                    border-transparent
                                @enderror
                            "
                        >


                        @error('email')

                            <p
                                class="mt-2 flex items-center gap-1.5 text-xs font-medium text-error"
                            >
                                <span
                                    class="material-symbols-outlined text-[16px]"
                                >
                                    error
                                </span>

                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    <!-- ===========================
                         PASSWORD
                    ============================ -->
                    <div>

                        <div
                            class="mb-2 flex items-center justify-between gap-3"
                        >

                            <label
                                for="password"
                                class="font-headline text-[12px] font-bold tracking-[.02em] text-chocolate"
                            >
                                Password
                            </label>


                            @if (Route::has('password.request'))

                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-xs font-bold text-tangelo transition hover:text-tangelo-dark hover:underline"
                                >
                                    Lupa password?
                                </a>

                            @endif

                        </div>


                        <div class="relative">

                            <input
                                type="password"
                                id="password"
                                name="password"

                                autocomplete="current-password"

                                placeholder="Masukkan password"

                                required

                                class="
                                    auth-input
                                    h-12
                                    w-full
                                    rounded-2xl
                                    border
                                    bg-soft
                                    pl-4
                                    pr-12
                                    text-sm
                                    text-ink
                                    placeholder:text-muted/50

                                    @error('password')
                                        input-error
                                        border-error
                                    @else
                                        border-transparent
                                    @enderror
                                "
                            >


                            <!-- Password visibility -->
                            <button
                                type="button"
                                id="togglePassword"

                                aria-label="Lihat password"

                                class="absolute right-3 top-1/2 flex -translate-y-1/2 items-center justify-center rounded-full p-1.5 text-muted transition hover:bg-linen hover:text-chocolate"
                            >

                                <span
                                    id="passwordIcon"
                                    class="material-symbols-outlined text-[20px]"
                                >
                                    visibility
                                </span>

                            </button>

                        </div>


                        @error('password')

                            <p
                                class="mt-2 flex items-center gap-1.5 text-xs font-medium text-error"
                            >
                                <span
                                    class="material-symbols-outlined text-[16px]"
                                >
                                    error
                                </span>

                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    <!-- ===========================
                         REMEMBER
                    ============================ -->

                    <div class="flex items-center">

                        <label
                            for="remember"
                            class="inline-flex cursor-pointer select-none items-center gap-2.5"
                        >

                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"

                                class="h-4 w-4 cursor-pointer rounded border-chocolate/20 accent-chocolate focus:ring-0"
                            >


                            <span
                                class="text-xs text-muted"
                            >
                                Ingat saya di perangkat ini
                            </span>

                        </label>

                    </div>



                    <!-- ===========================
                         SUBMIT
                    ============================ -->

                    <button
                        type="submit"

                        class="flex h-12 w-full items-center justify-center gap-2 rounded-2xl bg-chocolate px-5 font-headline text-sm font-bold text-white shadow-[0_8px_24px_rgba(73,38,29,.16)] transition hover:-translate-y-0.5 hover:bg-chocolate-dark hover:shadow-[0_12px_30px_rgba(73,38,29,.22)] active:translate-y-0"
                    >

                        <span>
                            Masuk
                        </span>

                        <span
                            class="material-symbols-outlined text-[18px]"
                        >
                            arrow_forward
                        </span>

                    </button>

                </form>



                <!-- ===============================
                     REGISTER
                ================================ -->

                <div
                    class="mt-7 border-t border-chocolate/10 pt-6 text-center"
                >

                    <p
                        class="text-sm text-muted"
                    >
                        Belum punya akun?

                        <a
                            href="{{ route('register') }}"
                            class="ml-1 font-bold text-tangelo transition hover:text-tangelo-dark hover:underline"
                        >
                            Daftar gratis
                        </a>
                    </p>

                </div>

            </div>



            <!-- =================================
                 SMALL NOTE
            ================================== -->

            <p
                class="mt-6 text-center text-xs leading-5 text-muted/80"
            >
                Jeda sejenak, lalu lanjutkan perjalananmu.
            </p>

        </div>

    </main>



    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <footer class="w-full px-5 pb-6 md:px-8 lg:px-12">

        <div
            class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 text-center sm:flex-row sm:text-left"
        >

            <p
                class="text-xs text-muted"
            >
                © {{ date('Y') }} Interlude.
            </p>


            <div
                class="flex items-center gap-5"
            >

                <a
                    href="#"
                    class="text-xs font-semibold text-muted transition hover:text-chocolate"
                >
                    Bantuan
                </a>

                <a
                    href="#"
                    class="text-xs font-semibold text-muted transition hover:text-chocolate"
                >
                    Privasi
                </a>

            </div>

        </div>

    </footer>

</div>



<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const togglePassword =
            document.getElementById('togglePassword');

        const passwordInput =
            document.getElementById('password');

        const passwordIcon =
            document.getElementById('passwordIcon');


        if (
            togglePassword &&
            passwordInput &&
            passwordIcon
        ) {

            togglePassword.addEventListener(
                'click',
                function () {

                    const currentlyHidden =
                        passwordInput.type === 'password';


                    passwordInput.type =
                        currentlyHidden
                            ? 'text'
                            : 'password';


                    passwordIcon.textContent =
                        currentlyHidden
                            ? 'visibility_off'
                            : 'visibility';


                    togglePassword.setAttribute(
                        'aria-label',

                        currentlyHidden
                            ? 'Sembunyikan password'
                            : 'Lihat password'
                    );

                }
            );

        }

    });
</script>


</body>
</html>