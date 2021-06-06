<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductRatingControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $normalUser;
    private User $adminUser;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        Event::fake();
        $this->normalUser = User::factory()->create();
        $this->adminUser = User::factory()->create();
        $this->product = Product::factory()->create();
    }

    public function test_rate_product()
    {
        Sanctum::actingAs($this->normalUser);

        $response = $this->postJson("/api/products/{$this->product->getKey()}/rate", [
            'score' => 5
        ]);

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('ratings', [
            'score' => 5,
            'rateable_id' => $this->product->getKey(),
            'rateable_type' => Product::class
        ]);
    }
}
