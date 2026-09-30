<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\InteractionNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_a_message_and_recipient_gets_notification(): void
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        $this->actingAs($sender)
            ->post(route('messages.store'), [
                'recipient_id' => $recipient->id,
                'body' => 'Halo, mau bertanya tentang tulisanmu.',
            ])
            ->assertRedirect(route('messages.index'));

        $this->assertDatabaseHas('messages', [
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'body' => 'Halo, mau bertanya tentang tulisanmu.',
        ]);

        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $recipient->id,
            'notifiable_type' => User::class,
        ]);
    }

    public function test_user_can_mark_a_notification_as_read(): void
    {
        $user = User::factory()->create();
        $user->notify(new InteractionNotification('message', 'Pesan baru.', route('messages.index')));
        $notification = $user->notifications()->firstOrFail();

        $this->actingAs($user)
            ->patch(route('notifications.read', $notification->id))
            ->assertRedirect();

        $this->assertNotNull($notification->fresh()->read_at);
    }
}
