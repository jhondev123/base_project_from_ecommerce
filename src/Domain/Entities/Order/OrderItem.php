<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order;

use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Product;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Toppings;

class OrderItem
{
    private Product $product;
    private int $quantity;
    private array $toppings = [];
    private ?float $price = null;
    public function getProduct(): Product
    {
        return $this->product;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function calculateTotalPriceItem(): float
    {
        $totalToppings = $this->calculateTotalPriceToppings();

        if ($this->price == null) {
            return ($this->product->getPrice() * $this->quantity) + $totalToppings;
        }
        return $this->price * $this->quantity + $totalToppings;

        return 0;
    }
    private function calculateTotalPriceToppings()
    {
        if (empty($this->toppings)) {
            return 0;
        }
        return array_reduce($this->toppings, function ($sum, Toppings $topping) {
            return $sum + $topping->getPrice();
        });
    }
}
