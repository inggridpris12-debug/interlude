        <!-- ARTICLE CONTENT -->
        <div class="article-body">
            <div class="article-inner">
                <!-- Category -->
                <div class="article-category">{{ $article->category }}</div>
                <!-- Title (SANS-SERIF) -->
                <h1 class="article-title">{{ $article->title }}</h1>
                <!-- Excerpt -->
                @if($article->excerpt)
                <p class="article-excerpt">{{ $article->excerpt }}</p>
                @endif
                <!-- Author -->
                <div class="article-author">
                    <div class="author-avatar {{ $article->user->profile_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->user->profile_photo) ? 'avatar-photo' : '' }}" style="{{ $article->user->profile_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->user->profile_photo) ? '--avatar-photo: url(' . asset('storage/' . $article->user->profile_photo) . ');' : 'background: linear-gradient(135deg, #FF8C5A, #FB4D00);' }}">
                        {{ substr($article->user->name, 0, 1) }}
                    </div>
                    <div class="author-details">
                        <span class="author-name">{{ strtoupper($article->user->name) }}</span>
                        <span class="article-date">
                            {{ $article->created_at->locale('id')->isoFormat('MMM DD, YYYY') }}
                        </span>
                    </div>
                </div>
                <div class="article-meta-row">
                    <span><i class="far fa-clock"></i> {{ $article->reading_time }} menit baca</span>
                    <span><i class="far fa-eye"></i> {{ number_format($article->views_count) }} dibaca</span>
                    @if($article->is_featured)
                        <span class="featured-note"><i class="fas fa-sparkles"></i> Pilihan Interlude</span>
                    @endif
                </div>
                <!-- Divider -->
                <div class="article-divider"></div>
                <!-- Cover Image -->
                @if($hasCoverImage)
                <figure class="article-figure">
                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                    <figcaption>Ilustrasi {{ strtolower($article->category) }}.</figcaption>
                </figure>
                @else
                    <div class="article-visual-placeholder" role="img" aria-label="Ilustrasi {{ $article->category }}">
                        <i class="fas fa-book-open"></i>
                        <span>{{ $article->category }}</span>
                    </div>
                @endif
                <!-- Article Text (SERIF - Playfair Display) -->
                <div class="article-text">
                    {!! $article->content !!}
                </div>
                <!-- Engagement Bar -->
                <div class="engagement-bar">
                    <!-- Like -->
                    <button
                        type="button"
                        class="engage-btn {{ $isLiked ? 'active' : '' }}"
                        onclick="toggleLike(@js(route('articles.like', $article)), this)"
                    >
                        <i class="{{ $isLiked ? 'fas' : 'far' }} fa-heart"></i>
                        <span>{{ $article->likes_count }}</span>
                    </button>
                    <!-- Comment -->
                    <button
                        type="button"
                        class="engage-btn"
                        onclick="document.getElementById('commentContent').focus()"
                    >
                        <i class="far fa-comment"></i>
                        <span>{{ $article->comments_count }}</span>
                    </button>
                    <!-- Save -->
                    <button
                        type="button"
                        class="engage-btn {{ $isBookmarked ? 'active' : '' }}"
                        onclick="toggleBookmark(@js(route('articles.bookmark', $article)))"
                    >
                        <i class="{{ $isBookmarked ? 'fas' : 'far' }} fa-bookmark"></i>
                        <span>Simpan</span>
                    </button>
                    <!-- Download -->
                    <a
                        href="{{ route('articles.download', $article) }}"
                        class="engage-btn download-btn"
                        aria-label="Unduh artikel"
                    >
                        <i class="fas fa-arrow-down"></i>
                        <span>Unduh</span>
                    </a>
                    <!-- Share -->
                    <button
                        type="button"
                        class="engage-btn"
                        onclick="shareArticle()"
                    >
                        <i class="fas fa-share-nodes"></i>
                        <span>Bagikan</span>
                    </button>
                    <!-- Quote Share -->
                    <button
                        type="button"
                        class="engage-btn quote-share-trigger"
                        id="openQuoteShareModal"
                        aria-label="Bagikan kutipan"
                    >
                        <i class="fas fa-quote-right"></i>
                        <span>Kutipan</span>
                    </button>
                </div>
                <section class="article-followup" aria-labelledby="conversation-heading">
                    <div class="followup-heading">
                        <div>
                            <span class="section-kicker">Ruang percakapan</span>
                            <h2 id="conversation-heading">Apa yang kamu pelajari dari cerita ini?</h2>
                        </div>
                        <span class="comment-count">{{ $article->comments->count() }} komentar</span>
                    </div>
                    @if(session('success'))
                        <div class="comment-success" role="status"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('articles.comments.store', $article) }}" class="comment-form">
                        @csrf
                        <label for="commentContent">Bagikan refleksimu</label>
                        <textarea id="commentContent" name="content" rows="3" maxlength="2000" placeholder="Apa yang paling mengena dari cerita ini?" required>{{ old('content') }}</textarea>
                        @error('content')
                            <span class="comment-error">{{ $message }}</span>
                        @enderror
                        <div class="comment-form-footer">
                            <span>Masuk sebagai {{ auth()->user()->name }}</span>
                            <button type="submit">Kirim komentar <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </form>
                    <div class="comment-list">
                        @forelse($article->comments as $comment)
                            <div class="comment-item">
                                <div class="comment-avatar">{{ substr($comment->user->name, 0, 1) }}</div>
                                <div class="comment-copy">
                                    <div class="comment-byline">
                                        <strong>{{ $comment->user->name }}</strong>
                                        <time datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->locale('id')->diffForHumans() }}</time>
                                    </div>
                                    <p>{{ $comment->content }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="comment-empty">
                                <i class="far fa-comment-dots"></i>
                                <p>Belum ada percakapan. Jadilah yang pertama membagikan refleksimu.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
                @if($relatedArticles->isNotEmpty())
                    <section class="related-section" aria-labelledby="related-heading">
                        <div class="followup-heading">
                            <div>
                                <span class="section-kicker">Lanjut membaca</span>
                                <h2 id="related-heading">Cerita lain dari topik {{ $article->category }}</h2>
                            </div>
                        </div>
                        <div class="related-grid">
                            @foreach($relatedArticles as $relatedArticle)
                                <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="related-card">
                                    <span class="related-category">{{ $relatedArticle->category }}</span>
                                    <h3>{{ $relatedArticle->title }}</h3>
                                    <span class="related-author">{{ $relatedArticle->user->name }} · {{ $relatedArticle->reading_time }} menit</span>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
        </div>
