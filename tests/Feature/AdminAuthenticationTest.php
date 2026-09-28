<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Article;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_log_in_and_reach_the_admin_dashboard(): void
    {
        $admin = Admin::factory()->create();

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($admin, 'admin');
        $response->assertRedirect(route('admin.dashboard_admin', absolute: false));

        $this->get(route('admin.dashboard_admin'))->assertOk();
    }

    public function test_admin_guard_can_view_the_admin_dashboard(): void
    {
        $admin = Admin::factory()->create();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard_admin'))
            ->assertOk();
    }

    public function test_admin_can_view_the_admin_users_page(): void
    {
        $admin = Admin::factory()->create();
        User::factory()->create();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.users'))
            ->assertOk();
    }

    public function test_admin_can_view_the_admin_reports_page(): void
    {
        $admin = Admin::factory()->create();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.reports'))
            ->assertOk();
    }

    public function test_admin_pages_render_reports_with_their_actions(): void
    {
        $admin = Admin::factory()->create();
        $author = User::factory()->create();
        $reporter = User::factory()->create();

        $article = Article::create([
            'user_id' => $author->id,
            'title' => 'Judul Artikel',
            'content' => 'Konten artikel.',
            'category' => 'Umum',
            'slug' => 'judul-artikel',
            'is_published' => true,
        ]);

        Report::create([
            'reporter_id' => $reporter->id,
            'article_id' => $article->id,
            'reason' => 'Spam',
            'description' => 'Konten tidak relevan.',
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard_admin'))
            ->assertOk()
            ->assertSee('Spam');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.reports'))
            ->assertOk()
            ->assertSee('Spam');
    }

    public function test_regular_user_cannot_view_the_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard_admin'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_log_out(): void
    {
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->post('/logout');

        $this->assertGuest('admin');
        $response->assertRedirect('/');
    }

    public function test_admin_can_log_out_via_admin_logout_route(): void
    {
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->post(route('admin.logout'));

        $this->assertGuest('admin');
        $response->assertRedirect(route('login'));
    }
}
