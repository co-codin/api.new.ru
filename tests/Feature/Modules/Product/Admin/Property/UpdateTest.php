<?php


namespace Tests\Feature\Modules\Product\Admin\Property;

use App\Enums\Status;
use Illuminate\Http\UploadedFile;
use Modules\Product\Enums\ProductPermission;
use Modules\Product\Models\Product;
use Modules\Property\Models\Property;
use Modules\Role\Models\Permission;
use Modules\User\Models\User;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_unauthenticated_cannot_update_property_in_product()
    {
        $product = Product::factory()->create();

        $property = Property::factory()->create();

        $response = $this->json('PUT', route('admin.product.property.update', $product), [
            'properties' => [
                [
                    'id' => $property->id,
                    'pretty_key' => $prettyKey = 'test_key',
                    'pretty_value' => $prettyValue = 'test_value',
                ],
            ]
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_can_update_property_in_product()
    {
        $user = User::factory()->create([
            'email' => 'admin@medeq.ru'
        ]);

        $permission = Permission::factory()->create([
            'name' => ProductPermission::EDIT_PRODUCTS
        ]);

        $user->givePermissionTo($permission->name);

        $response = $this->json('POST', route('auth.login'), [
            'email' => 'admin@medeq.ru',
            'password' => 'admin1',
        ]);

        $this->withToken($response->json('token'));

        $product = Product::factory()->create();

        $property = Property::factory()->create();

        $response = $this->json('PUT', route('admin.product.property.update', $product), [
            'properties' => [
                [
                    'id' => $property->id,
                    'pretty_key' => $prettyKey = 'test_key',
                    'pretty_value' => $prettyValue = 'test_value',
                ],
            ]
        ]);

        $response->assertNoContent();

        $this->assertDatabaseHas('product_property', [
            'property_id' => $property->id,
            'product_id' => $product->id,
            'pretty_key' => $prettyKey,
            'pretty_value' => $prettyValue,
        ]);
    }
}
