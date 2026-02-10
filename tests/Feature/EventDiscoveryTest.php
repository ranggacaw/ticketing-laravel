<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventDiscoveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_event_list()
    {
        $publishedEvent = Event::factory()->create([
            'status' => 'published',
            'name' => 'Published Rock Concert'
        ]);
        $draftEvent = Event::factory()->create([
            'status' => 'draft',
            'name' => 'Secret Draft Event'
        ]);

        $response = $this->get(route('events.index'));

        $response->assertStatus(200);
        $response->assertSee('Published Rock Concert');
        $response->assertDontSee('Secret Draft Event');
    }

    public function test_can_view_event_details()
    {
        $event = Event::factory()->create(['status' => 'published']);

        $response = $this->get(route('events.show', $event));

        $response->assertStatus(200);
        $response->assertSee($event->name);
    }

    public function test_cannot_view_unpublished_event_details()
    {
        $event = Event::factory()->create(['status' => 'draft']);

        $response = $this->get(route('events.show', $event));

        $response->assertStatus(404);
    }
}
