<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleInteractionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_and_unlike_an_article(): void
    {
        $user = User::factory()->create();
        $article = $this->createArticle($user);

        $response = $this->actingAs($user)->postJson(route('articles.like', $article));

        $response->assertOk()->assertJson(['success' => true, 'liked' => true, 'count' => 1]);
        $this->assertDatabaseHas('likes', ['user_id' => $user->id, 'article_id' => $article->id]);

        $this->actingAs($user)
            ->postJson(route('articles.like', $article))
            ->assertJson(['success' => true, 'liked' => false, 'count' => 0]);
    }

    public function test_user_can_save_and_unsave_an_article(): void
    {
        $user = User::factory()->create();
        $article = $this->createArticle($user);

        $this->actingAs($user)
            ->postJson(route('articles.bookmark', $article))
            ->assertOk()
            ->assertJson(['success' => true, 'bookmarked' => true]);

        $this->assertDatabaseHas('bookmarks', ['user_id' => $user->id, 'article_id' => $article->id]);

        $this->actingAs($user)
            ->postJson(route('articles.bookmark', $article))
            ->assertJson(['success' => true, 'bookmarked' => false]);
    }

    public function test_user_can_comment_on_an_article(): void
    {
        $user = User::factory()->create();
        $article = $this->createArticle($user);

        $this->actingAs($user)
            ->post(route('articles.comments.store', $article), ['content' => 'Tulisan ini sangat membantu.'])
            ->assertRedirect(route('articles.show', $article->slug));

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'article_id' => $article->id,
            'content' => 'Tulisan ini sangat membantu.',
        ]);
    }

    private function createArticle(User $user): Article
    {
        return Article::create([
            'user_id' => $user->id,
            'title' => 'Cerita Interaksi',
            'slug' => 'cerita-interaksi-'.$user->id,
            'content' => 'Isi cerita.',
            'category' => 'Penelitian',
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
