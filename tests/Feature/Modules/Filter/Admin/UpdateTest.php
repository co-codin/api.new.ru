<?php


namespace Tests\Feature\Modules\Filter\Admin;

use Modules\Filter\Models\Filter;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_filter()
    {
        //
    }

    public function test_authenticated_can_update_filter()
    {
        $filter = Filter::factory()->create();

        $response = $this->json('PATCH', route('admin.filters.update', $filter), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('filters', [
            'name' => $newName,
        ]);
    }
}
