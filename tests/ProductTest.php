<?php


class ProductTest extends \PHPUnit\Framework\TestCase
{
    public function testcomputeTVAFoodProduct()
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, 20);

        $this->assertSame(1.1, $product->computeTVA());
    }

}
