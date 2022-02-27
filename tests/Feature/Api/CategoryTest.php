<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $endpoint = '/categories';

    /**
     * A basic feature test get categories.
     *
     * @return void
     */
    public function test_get_all_categories()
    {
        Category::factory()->count(4)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(4, 'data');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test error get single category.
     *
     * @return void
     */
    public function test_error_get_single_category()
    {
        $category = 'fake-url';

        $response = $this->getJson("{$this->endpoint}/{$category}");

        $response->assertStatus(404);
    }

    /**
     * A basic feature test get single category.
     *
     * @return void
     */
    public function test_get_single_category()
    {
        $category = Category::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$category->url}");

        $response->assertStatus(200);
    }

    /**
     * A basic feature test validations store category.
     *
     * @return void
     */
    public function test_validations_store_category()
    {
        $response = $this->postJson($this->endpoint, [
            'title' => '',
            'description' => ''
        ]);

        $response->assertStatus(422);
    }

    /**
     * A basic feature test store category.
     *
     * @return void
     */
    public function test_store_category()
    {
        $response = $this->postJson($this->endpoint, [
            'title' => 'Category 01',
            'description' => 'Description of category'
        ]);

        $response->assertStatus(201);
    }

    /**
     * A basic feature test update category.
     *
     * @return void
     */
    public function test_update_category()
    {
        $category = Category::factory()->create();

        $data = [
            'title' => 'Title Updated',
            'description' => 'Description Updated'
        ];

        $response = $this->putJson("{$this->endpoint}/fake-category", $data);
        $response->assertStatus(404);

        $response = $this->putJson("{$this->endpoint}/{$category->url}", []);
        $response->assertStatus(422);

        $response = $this->putJson("{$this->endpoint}/{$category->url}", $data);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test delete category.
     *
     * @return void
     */
    public function test_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/fake-category");
        $response->assertStatus(404);

        $response = $this->deleteJson("{$this->endpoint}/{$category->url}");
        $response->assertStatus(204);
    }
}
