        <!-- TOP NAVBAR -->
        <nav class="article-topbar">
            <a href="{{ route('dashboard') }}" class="close-btn">
                <i class="fas fa-times"></i>
            </a>
            <div class="topbar-center">
                <div class="topbar-avatar {{ $article->user->profile_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->user->profile_photo) ? 'avatar-photo' : '' }}" style="{{ $article->user->profile_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->user->profile_photo) ? '--avatar-photo: url(' . asset('storage/' . $article->user->profile_photo) . ');' : 'background: linear-gradient(135deg, #FF8C5A, #FB4D00);' }}">
                    {{ substr($article->user->name, 0, 1) }}
                </div>
            </div>
            <div class="topbar-right">
                @if(auth()->id() === $article->user_id)
                    <a href="{{ route('articles.edit', $article) }}" class="edit-article-btn"><i class="fas fa-pen"></i> Edit artikel</a>
                @endif
                <!-- Reader settings -->
                <button
                    type="button"
                    class="reader-trigger"
                    id="readerTrigger"
                    aria-label="Pengaturan keterbacaan"
                    aria-expanded="false"
                    aria-controls="readerSettings"
                >
                    <span class="reader-trigger-small">A−</span>
                    <span class="reader-trigger-slash">/</span>
                    <span class="reader-trigger-large">A+</span>
                </button>
                <button type="button" class="icon-btn {{ $isBookmarked ? 'active' : '' }}" onclick="toggleBookmark(@js(route('articles.bookmark', $article)))" aria-label="Simpan artikel">
                    <i class="{{ $isBookmarked ? 'fas' : 'far' }} fa-bookmark"></i>
                </button>
                <button type="button" class="icon-btn" onclick="shareArticle()" aria-label="Bagikan artikel">
                    <i class="fas fa-share-nodes"></i>
                </button>
            </div>
        </nav>
