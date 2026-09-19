<x-guest-layout>
    <div class="auth-header">
        <h1 class="auth-title">Selamat datang kembali!</h1>
        <p class="auth-subtitle">Masuk untuk melanjutkan berbagi cerita</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

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
                autofocus
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
                placeholder="Masukkan password"
                required
            >
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="checkbox-group">
            <input 
                type="checkbox" 
                id="remember" 
                name="remember" 
                class="checkbox"
            >
            <label for="remember" class="checkbox-label">Ingat saya</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">Masuk</button>

        <!-- Register Link -->
        <p class="auth-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a>
        </p>
    </form>
</x-guest-layout>