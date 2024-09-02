<?php

namespace Jhonattan\BaseProjectFromEcommerce\Tests\Unit\Domain\Entities;

use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Group;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Product;

class ProductTest extends TestCase
{
    public function testIntanceProduct()
    {
        $product = new Product('123', 'acai', 'this acai is good', 20, new Group('123', 'acais'));
        $this->assertEquals('acai', $product->getName());
        $this->assertEquals('this acai is good', $product->getDescription());
        $this->assertEquals(20, $product->getPrice());
        $this->assertEquals('acais', $product->getGroupName());
        $this->assertEquals('acais', $product->getGroupName());
    }
}
