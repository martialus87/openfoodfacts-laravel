<?php

namespace Hypoid\OpenFoodFactsLaravel\Tests;

use OpenFoodFacts\Laravel\Facades\OpenFoodFacts;

class ProductSearchTest extends Base\FacadeTestCase
{
    /** @test */
    public function it_returns_a_laravelcollection_with_arrays(): void
    {
        $results = OpenFoodFacts::find('Stir-Fry Rice Noodles');

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $results);

        $this->assertTrue($results->isNotEmpty());

        $results->each(function ($arr) {
            $this->assertIsArray($arr);
        });
    }

    /** @test */
    public function it_returns_an_empty_laravelcollection_when_no_results_found(): void
    {
        $results = OpenFoodFacts::find('no-such-product-exists');

        // Call to method PHPUnit\Framework\Assert::assertTrue() with bool will always evaluate to false.
        // 💡 Because the type is coming from a PHPDoc
        $this->assertEquals(true, $results->isEmpty());
    }

    /** @test */
    public function it_throws_an_exception_on_too_many_results(): void
    {
        $this->expectException('Exception');

        OpenFoodFacts::find('cola');
    }

    /** @test */
    public function it_throws_an_exception_when_argument_empty(): void
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Specify a search term to find data for matching products');

        OpenFoodFacts::find('');
    }
}
