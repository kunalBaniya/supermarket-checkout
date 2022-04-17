<?php 

declare (strict_types = 1);

class Cart 
{
    protected array $cart = [
        'items' => [],
        'totalPrice' => 0.0
    ];

    public function addItem(string $item, int $quantity): void
    {
        array_push($this->cart['items'], [
            'item' => $item,
            'quantity' => $quantity
        ]); 
    }

    public function clear(): void 
    {
        $this->cart['items'] = [];
    }

    public function getItems(): array
    {
        return $this->cart;
    }
}