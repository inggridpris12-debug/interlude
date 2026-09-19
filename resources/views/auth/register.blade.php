<x-guest-layout>
    <div class="auth-header">
        <h1 class="auth-title">Buat akun</h1>
        <p class="auth-subtitle">Bergabung dengan komunitas mahasiswa Interlude</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                class="form-input @error('name') error @enderror" 
                placeholder="Nama lengkap Anda"
                value="{{ old('name') }}" 
                required 
                autofocus
            >
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-input @error('email') error @enderror" 
                placeholder="nama@email.com"
                value="{{ old('email') }}" 
                required
            >
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-input @error('password') error @enderror" 
                placeholder="Minimal 8 karakter"
                required
            >
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                class="form-input" 
                placeholder="Ulangi password"
                required
            >
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">Daftar gratis</button>

        <!-- Login Link -->
        <p class="auth-link">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
        </p>
    </form>
</x-guest-layout>