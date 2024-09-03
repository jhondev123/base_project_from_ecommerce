<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Order;

use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Product;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Topping;

class OrderItem
{
    private Product $product;
    private int $quantity;
    private array $toppings = [];
    private float $price = 0;
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->validateQuantity($quantity);
        $this->quantity = $quantity;
    }
    public function getProduct(): Product
    {
        return $this->product;
    }
    public function setPrice(float $price)
    {
        $this->price = $price;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function calculateTotalPriceItem(): float
    {
        $totalToppings = $this->calculateTotalPriceToppings();

        if ($this->price == 0) {
            return ($this->product->getPrice() + $totalToppings) * $this->quantity;
        }
        return ($this->price  + $totalToppings) * $this->quantity;

        return 0;
    }
    private function calculateTotalPriceToppings()
    {
        if (empty($this->toppings)) {
            return 0;
        }
        return array_reduce($this->toppings, function ($sum, Topping $topping) {
            return $sum + $topping->getPrice();
        });
    }
    private function validateQuantity($quantity)
    {
        if ($quantity <= 0) {
            throw new \DomainException('Quantity must be greater than 0');
        }
    }
    public function addTopping(Topping $topping): self
    {
        array_push($this->toppings, $topping);
        return $this;
    }
    public function getToppings(): array
    {
        return $this->toppings;
    }
}
