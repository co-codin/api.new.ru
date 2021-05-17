<?php


namespace Tests\Feature\Modules\Achievement\Admin;

use Modules\Achievement\Models\Achievement;
use Tests\TestCase;

class DeleteTest extends TestCase
{
//    public function test_unauthenticated_cannot_delete_achievement()
//    {
//        //
//    }

    public function test_authenticated_can_delete_achievement()
    {
        $achievement = Achievement::factory()->create();

        $response = $this->deleteJson(route('admin.achievements.destroy', $achievement));

        $response->assertNoContent();

        $this->assertDeleted($achievement);
    }
}
