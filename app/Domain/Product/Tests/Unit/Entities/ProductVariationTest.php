<?php

namespace App\Domain\Product\Tests\Unit\Entities;

use Tests\TestCase;
use App\Common\Transformers\Money;
use App\Domain\Product\Entities\Stock;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Entities\ProductVariationType;

class ProductVariationTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_product()
    {
        $variation = $this->productVariationFactory->create();
        $this->assertInstanceOf(Product::class, $variation->product);
    }

    /** @test */
    public function it_can_check_if_the_variation_price_is_different_to_the_product_price()
    {
        $product = $this->productFactory->create([
            'price' => 1000,
        ]);
        $variation = $this->productVariationFactory->create([
            'price' => 2000,
            'product_id' => $product->id,
        ]);
        $this->assertTrue($variation->priceVaries());
    }

    /** @test */
    public function it_can_get_the_minimum_stock_for_a_given_value()
    {
        $variation = $this->productVariationFactory->create();
        $variation->stocks()->save(
            $this->stockFactory->make([
                'quantity' => $quantity = 5,
            ])
        );
        $this->assertEquals($variation->minStock(200), $quantity);
    }

    /** @test */
    public function it_checks_if_it_is_in_stock()
    {
        $variation = $this->productVariationFactory->create();
        $variation->stocks()->save(
            $this->stockFactory->make([
                'quantity' => 5,
            ])
        );
        $this->assertTrue($variation->in_stock);
    }

    /** @test */
    public function it_fetches_the_stock_count()
    {
        $variation = $this->productVariationFactory->create();
        $variation->stocks()->save(
            $this->stockFactory->make([
                'quantity' => 5,
            ])
        );
        $variation->stocks()->save(
            $this->stockFactory->make([
                'quantity' => 5,
            ])
        );
        $this->assertEquals($variation->stock_count, 10);
    }

    /** @test */
    public function it_has_in_stock_pivot_within_stock_information()
    {
        $variation = $this->productVariationFactory->create();
        $variation->stocks()->save(
            $this->stockFactory->make([
                'quantity' => $quantity = 5,
            ])
        );
        $this->assertTrue(!!$variation->stock->first()->pivot->in_stock);
    }

    /** @test */
    public function it_has_many_stocks()
    {
        $variation = $this->productVariationFactory->create();
        $variation->stocks()->save(
            $this->stockFactory->make()
        );
        $this->assertInstanceOf(Stock::class, $variation->stocks->first());
    }

    /** @test */
    public function it_has_one_variation()
    {
        $variation = $this->productVariationFactory->create();
        $this->assertInstanceOf(ProductVariationType::class, $variation->type);
    }

    /** @test */
    public function it_has_stock_count_pivot_within_stock_information()
    {
        $variation = $this->productVariationFactory->create();
        $variation->stocks()->save(
            $this->stockFactory->make([
                'quantity' => $quantity = 5,
            ])
        );
        $this->assertEquals($variation->stock->first()->pivot->stock, $quantity);
    }

    /** @test */
    public function it_has_stock_information()
    {
        $variation = $this->productVariationFactory->create();
        $variation->stocks()->save(
            $this->stockFactory->make()
        );
        $this->assertInstanceOf(ProductVariation::class, $variation->stock->first());
    }

    /** @test */
    public function it_retruns_a_money_instance_for_the_price()
    {
        $variation = $this->productVariationFactory->create();
        $this->assertInstanceOf(Money::class, $variation->price);
    }

    /** @test */
    public function it_returns_a_formatted_price()
    {
        $variation = $this->productVariationFactory->create([
            'price' => 1000,
        ]);
        $this->assertEquals($variation->formattedPrice, '١٠٫٠٠ ر.س.‏');
    }

    /** @test */
    public function it_returns_the_product_price_if_price_is_null()
    {
        $product = $this->productFactory->create([
            'price' => 1000,
        ]);
        $variation = $this->productVariationFactory->create([
            'price' => null,
            'product_id' => $product->id,
        ]);
        $this->assertEquals($product->price->amount(), $variation->price->amount());
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->productFactory = Product::factory();
        $this->productVariationFactory = ProductVariation::factory();
        $this->stockFactory = Stock::factory();
    }
}
