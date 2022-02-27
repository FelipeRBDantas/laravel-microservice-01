<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    protected $endpoint = '/companies';

    /**
     * A basic feature test get companies.
     *
     * @return void
     */
    public function test_get_all_companies()
    {
        Company::factory()->count(4)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(4, 'data');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test error get single company.
     *
     * @return void
     */
    public function test_error_get_single_company()
    {
        $company = 'fake-uuid';

        $response = $this->getJson("{$this->endpoint}/{$company}");

        $response->assertStatus(404);
    }

    /**
     * A basic feature test get single company.
     *
     * @return void
     */
    public function test_get_single_company()
    {
        $company = Company::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$company->uuid}");

        $response->assertStatus(200);
    }

    /**
     * A basic feature test validations store company.
     *
     * @return void
     */
    public function test_validations_store_company()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => ''
        ]);

        $response->assertStatus(422);
    }

    /**
     * A basic feature test store company.
     *
     * @return void
     */
    public function test_store_company()
    {
        $category = Category::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'category_id' => $category->id,
            'name' => 'DantasIT',
            'email' => 'feliperbdantas@outlook.com',
            'whatsapp' => '11988888888'
        ]);

        $response->assertStatus(201);
    }

    /**
     * A basic feature test update company.
     *
     * @return void
     */
    public function test_update_company()
    {
        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $data = [
            'category_id' => $category->id,
            'name' => 'DantasIT',
            'email' => 'feliperbdantas@outlook.com',
            'whatsapp' => '11988888888'
        ];

        $response = $this->putJson("{$this->endpoint}/fake-company", $data);
        $response->assertStatus(404);

        $response = $this->putJson("{$this->endpoint}/{$company->uuid}", []);
        $response->assertStatus(422);

        $response = $this->putJson("{$this->endpoint}/{$company->uuid}", $data);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test delete company.
     *
     * @return void
     */
    public function test_delete_company()
    {
        $company = Company::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/fake-uuid");
        $response->assertStatus(404);

        $response = $this->deleteJson("{$this->endpoint}/{$company->uuid}");
        $response->assertStatus(204);
    }
}
