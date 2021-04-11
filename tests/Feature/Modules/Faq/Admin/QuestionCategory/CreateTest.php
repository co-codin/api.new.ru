<?php


namespace Tests\Feature\Modules\Faq\Admin\QuestionCategory;


use Modules\Faq\Models\QuestionCategory;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_question_category()
    {
        //
    }

    public function test_authenticated_can_create_question_category()
    {
        $questionCategoryData = QuestionCategory::factory()->raw();

        $response = $this->json('POST', route('admin.question_categories.store'), $questionCategoryData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'slug',
            ]
        ]);
        $this->assertDatabaseHas('question_categories', [
            'name' => $questionCategoryData['name'],
        ]);
    }
}