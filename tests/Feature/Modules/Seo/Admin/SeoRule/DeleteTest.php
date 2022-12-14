<?php


namespace Tests\Feature\Modules\Seo\Admin\SeoRule;

use Modules\Seo\Models\SeoRule;
use Tests\TestCase;
use function route;

class DeleteTest extends TestCase
{
    public function test_authenticated_can_delete_seo_rule()
    {
        $this->authenticateUser();

        $seoRule = SeoRule::factory()->create();

        $response = $this->json('DELETE', route('admin.seo-rules.destroy', $seoRule));

        $response->assertNoContent();

        $this->assertDeleted($seoRule);
    }
}
