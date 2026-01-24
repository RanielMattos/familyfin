<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaxonomyEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_taxonomy_endpoint_returns_groups_with_children(): void
    {
        // roda os seeders (inclui TaxonomySeeder)
        $this->seed();

        $res = $this->get('/taxonomia')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'type',
                        'direction',
                        'name',
                        'slug',
                        'description',
                        'children' => [
                            '*' => [
                                'id',
                                'type',
                                'direction',
                                'name',
                                'slug',
                                'description',
                                'children',
                            ],
                        ],
                    ],
                ],
            ]);

        $data = $res->json('data');

        // sanity checks
        $this->assertIsArray($data);
        $this->assertGreaterThanOrEqual(8, count($data)); // pelo seed atual, 12 grupos

        foreach ($data as $group) {
            $this->assertEquals('GROUP', $group['type']);
            $this->assertIsArray($group['children']);
        }
    }
}
