<?php

namespace App\Domain\Product\Tests\Unit\Entities;

use Tests\TestCase;
use App\Common\Transformers\Money;
use App\Domain\Product\Entities\Stock;
use App\Domain\Product\Entities\Product;
use App\Domain\Category\Entities\Category;
use App\Domain\Product\Entities\ProductVariation;

class ProductTest extends TestCase
{
    /** @test */
    public function it_can_check_if_its_in_stock()
    {
        $product = $this->productFactory->create();
        $product->variations()->save(
            $variation = $this->productVariationFactory->create()
        );
        $variation->stocks()->save(
            $this->stockFactory->make()
        );
        $this->assertTrue($product->in_stock);
    }

    /** @test */
    public function it_gets_the_stock_count()
    {
        $product = $this->productFactory->create();
        $product->variations()->save(
            $variation = $this->productVariationFactory->create()
        );
        $variation->stocks()->save(
            $this->stockFactory->make([
                'quantity' => 5,
            ])
        );
        $this->assertEquals($product->stock_count, 5);
    }

    /** @test */
    public function it_has_many_categories()
    {
        $product = $this->productFactory->create();
        $product->categories()->save(
            $this->categoryFactory->create()
        );
        $this->assertInstanceOf(Category::class, $product->categories->first());
    }

    /** @test */
    public function it_has_many_variations()
    {
        $product = $this->productFactory->create();
        $product->variations()->save(
            $this->productVariationFactory->create([
                'product_id' => $product->id,
            ])
        );
        $this->assertInstanceOf(ProductVariation::class, $product->variations->first());
    }

    /** @test */
    public function it_retruns_a_money_instance_for_the_price()
    {
        $product = $this->productFactory->create();
        $this->assertInstanceOf(Money::class, $product->price);
    }

    /** @test */
    public function it_returns_a_formatted_price()
    {
        $product = $this->productFactory->create([
            'price' => 1000,
        ]);
        $this->assertEquals($product->formattedPrice, '١٠٫٠٠ ج.م.‏');
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->productFactory = Product::factory();
        $this->productVariationFactory = ProductVariation::factory();
        $this->categoryFactory = Category::factory();
        $this->stockFactory = Stock::factory();
    }
}
