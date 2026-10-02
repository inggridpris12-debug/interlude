<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Article;
use App\Models\Podcast;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Admin
    {
        return Admin::factory()->create();
    }

    private function article(User $author, array $attributes = []): Article
    {
        return Article::create(array_merge([
            'user_id' => $author->id,
            'title' => 'Cerita Kurasi',
            'content' => 'Isi cerita kurasi.',
            'category' => 'Penelitian',
        ], $attributes));
    }

    private function podcast(User $creator, array $attributes = []): Podcast
    {
        return Podcast::create(array_merge([
            'user_id' => $creator->id,
            'title' => 'Episode Perdana',
            'media_type' => 'audio',
            'is_published' => true,
            'published_at' => now(),
        ], $attributes));
    }

    public function test_admin_can_view_the_articles_management_page(): void
    {
        $admin = $this->admin();
        $article = $this->article(User::factory()->create(), ['is_published' => true]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.articles'))
            ->assertOk()
            ->assertSee('Artikel & Kurasi')
            ->assertSee($article->title);
    }

    public function test_admin_can_view_the_podcasts_management_page(): void
    {
        $admin = $this->admin();
        $podcast = $this->podcast(User::factory()->create());

        $this->actingAs($admin, 'admin')
            ->get(route('admin.podcasts'))
            ->assertOk()
            ->assertSee('Podcast Hub')
            ->assertSee($podcast->title);
    }

    public function test_admin_can_view_the_settings_page(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->get(route('admin.settings'))
            ->assertOk()
            ->assertSee('Pengaturan')
            ->assertSee('Identitas Situs');
    }

    public function test_admin_can_publish_and_unpublish_an_article(): void
    {
        $admin = $this->admin();
        $article = $this->article(User::factory()->create(), ['is_published' => true, 'published_at' => now()]);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.articles.publish', $article))
            ->assertRedirect();

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    public function test_admin_can_feature_and_unfeature_an_article(): void
    {
        $admin = $this->admin();
        $article = $this->article(User::factory()->create());

        $this->actingAs($admin, 'admin')
            ->post(route('admin.articles.feature', $article))
            ->assertRedirect();

        $this->assertDatabaseHas('articles', ['id' => $article->id, 'is_featured' => true]);
    }

    public function test_featured_limit_is_enforced(): void
    {
        $admin = $this->admin();
        $author = User::factory()->create();

        Setting::set('featured_limit', '1', 'moderasi');
        $this->article($author, ['is_featured' => true]);

        $candidate = $this->article($author, ['title' => 'Artikel Kedua']);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.articles.feature', $candidate))
            ->assertSessionHasErrors('featured');

        $this->assertDatabaseHas('articles', ['id' => $candidate->id, 'is_featured' => false]);
    }

    public function test_admin_can_delete_an_article(): void
    {
        $admin = $this->admin();
        $article = $this->article(User::factory()->create());

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.articles.destroy', $article))
            ->assertRedirect();

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_admin_can_unpublish_a_podcast(): void
    {
        $admin = $this->admin();
        $podcast = $this->podcast(User::factory()->create());

        $this->actingAs($admin, 'admin')
            ->post(route('admin.podcasts.publish', $podcast))
            ->assertRedirect();

        $this->assertDatabaseHas('podcasts', [
            'id' => $podcast->id,
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    public function test_admin_can_delete_a_podcast(): void
    {
        $admin = $this->admin();
        $podcast = $this->podcast(User::factory()->create());

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.podcasts.destroy', $podcast))
            ->assertRedirect();

        $this->assertDatabaseMissing('podcasts', ['id' => $podcast->id]);
    }

    public function test_admin_can_update_platform_settings(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->put(route('admin.settings.update'), [
                'site_name' => 'Interlude Kampus',
                'site_tagline' => 'Cerita Lintas Kampus',
                'site_description' => 'Ruang berbagi cerita mahasiswa.',
                'contact_email' => 'kurator@interlude.id',
                'registration_open' => '1',
                'featured_limit' => 8,
                'podcast_upload_max_mb' => 250,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('settings', ['key' => 'site_name', 'value' => 'Interlude Kampus']);
        $this->assertDatabaseHas('settings', ['key' => 'podcast_upload_max_mb', 'value' => '250']);
    }

    public function test_admin_can_update_their_account(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin, 'admin')
            ->put(route('admin.settings.account'), [
                'name' => 'Kurator Baru',
                'email' => 'kurator.baru@interlude.id',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('admins', [
            'id' => $admin->id,
            'name' => 'Kurator Baru',
            'email' => 'kurator.baru@interlude.id',
        ]);
    }

    public function test_regular_user_cannot_access_the_admin_management_pages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.articles'))->assertRedirect(route('login'));
        $this->actingAs($user)->get(route('admin.podcasts'))->assertRedirect(route('login'));
        $this->actingAs($user)->get(route('admin.settings'))->assertRedirect(route('login'));
    }

    public function test_registration_is_blocked_when_disabled(): void
    {
        Setting::set('registration_open', '0', 'moderasi');

        $this->get(route('register'))->assertForbidden();

        $this->post(route('register'), [
            'name' => 'Mahasiswa Baru',
            'email' => 'mahasiswa@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertForbidden();
    }
}
