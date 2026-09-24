<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlesManageTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_their_articles(): void
    {
        $user = User::factory()->create();
        $article = Article::create([
            'user_id' => $user->id,
            'title' => 'Cerita Pertama',
            'slug' => 'cerita-pertama',
            'content' => 'Isi cerita pertama.',
            'category' => 'Penelitian',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('articles.manage'));

        $response->assertOk()->assertSee($article->title);
    }

    public function test_guest_cannot_view_article_management(): void
    {
        $this->get(route('articles.manage'))->assertRedirect(route('login'));
    }

    public function test_user_cannot_delete_another_users_article(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $article = Article::create([
            'user_id' => $owner->id,
            'title' => 'Karya Milik Orang Lain',
            'slug' => 'karya-milik-orang-lain',
            'content' => 'Isi karya.',
            'category' => 'Magang',
        ]);

        $this->actingAs($intruder)
            ->delete(route('articles.destroy', $article))
            ->assertForbidden();

        $this->assertDatabaseHas('articles', ['id' => $article->id]);
    }

    public function test_owner_can_delete_their_article(): void
    {
        $user = User::factory()->create();
        $article = Article::create([
            'user_id' => $user->id,
            'title' => 'Karya Yang Dihapus',
            'slug' => 'karya-yang-dihapus',
            'content' => 'Isi karya.',
            'category' => 'Organisasi',
        ]);

        $this->actingAs($user)
            ->delete(route('articles.destroy', $article))
            ->assertRedirect(route('articles.manage'));

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_authenticated_user_can_view_saved_articles(): void
    {
        $user = User::factory()->create();
        $author = User::factory()->create();
        $article = Article::create([
            'user_id' => $author->id,
            'title' => 'Bacaan Yang Disimpan',
            'slug' => 'bacaan-yang-disimpan',
            'content' => 'Isi bacaan.',
            'category' => 'Tips Belajar',
            'is_published' => true,
            'published_at' => now(),
        ]);
        Bookmark::create(['user_id' => $user->id, 'article_id' => $article->id]);

        $this->actingAs($user)
            ->get(route('articles.saved'))
            ->assertOk()
            ->assertSee($article->title);
    }
}
