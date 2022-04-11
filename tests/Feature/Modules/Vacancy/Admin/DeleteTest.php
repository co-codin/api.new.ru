<?php


namespace Tests\Feature\Modules\Vacancy\Admin;


use Modules\Vacancy\Models\Vacancy;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_authenticated_can_delete_vacancy()
    {
        $this->authenticateUser();

        $vacancy = Vacancy::factory()->create();

        $response = $this->deleteJson(route('admin.vacancies.destroy', $vacancy));

        $response->assertNoContent();

        $this->assertSoftDeleted($vacancy);
    }
}
