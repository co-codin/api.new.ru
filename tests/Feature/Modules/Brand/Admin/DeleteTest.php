<?php


namespace Tests\Feature\Modules\Brand\Admin;

use Modules\Brand\Models\Brand;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_unauthenticated_cannot_delete_brand()
    {
        //
    }

    public function test_authenticated_can_delete_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->deleteJson(route('admin.brands.destroy', $brand));

        $response->assertNoContent(204);

        $this->assertSoftDeleted($brand);
    }
}