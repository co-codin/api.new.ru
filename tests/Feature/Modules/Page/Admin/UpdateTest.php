<?php


namespace Tests\Feature\Modules\Page\Admin;

use App\Enums\Status;
use Modules\Page\Models\Page;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_authenticated_can_update_page()
    {
        $this->authenticateUser();

        $page = Page::factory()->create([
            'status' => Status::ACTIVE,
        ]);

        $response = $this->json('PATCH', route('admin.pages.update', $page), [
            'name' => $newName = 'new name',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('pages', [
            'name' => $newName,
        ]);
    }
}
