<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test get categories.
     *
     * @return void
     */
    public function test_get_all_categories()
    {
        Category::factory()->count(4)->create();

        $response = $this->getJson('/categories');

        $response->assertJsonCount(4, 'data');

        $response->assertStatus(200);
    }
}
