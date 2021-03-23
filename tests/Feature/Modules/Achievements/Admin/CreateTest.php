<?php


namespace Tests\Feature\Modules\Achievements\Admin;

use Modules\Achievement\Models\Achievement;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_achievement()
    {
        //
    }

    public function test_authenticated_can_create_achievement()
    {
        $achievementData = Achievement::factory()->raw();

        $response = $this->json('POST', route('admin.achievements.store'), $achievementData);

        $response->status(201);
        $response->assertJson([
            'data' => [
                'name' => $achievementData['name'],
                'image' => $achievementData['image'],
                'is_enabled' => $achievementData['is_enabled']
            ]
        ]);
        $this->assertDatabaseHas('achievements', [
            'name' => $achievementData['name'],
            'image' => $achievementData['image'],
            'is_enabled' => $achievementData['is_enabled']
        ]);
    }
}
