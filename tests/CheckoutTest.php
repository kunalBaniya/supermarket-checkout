<?php 

declare(strict_types=1);

require 'autoload.php';

use PHPUnit\Framework\TestCase;

final class CheckoutTest extends TestCase 
{
    public function testCalculateTotalPriceForItemA(): void 
    {
        $checkout = new Checkout();
        $cart = new Cart();

        $items = [
            ['item' => 'A', 'qty' => 1, 'expected' => 50],
            ['item' => 'A', 'qty' => 2, 'expected' => 100],
            ['item' => 'A', 'qty' => 3, 'expected' => 130],
            ['item' => 'A', 'qty' => 4, 'expected' => 180],
            ['item' => 'A', 'qty' => 5, 'expected' => 230],
            ['item' => 'A', 'qty' => 6, 'expected' => 260],
        ];

        foreach ($items as $item) 
        {
            $cart->addItem($item['item'], $item['qty']);
            $cartItems = $cart->getItems();
            $total = $checkout->calculateTotalPrice($cartItems['items']); 
            $this->assertIsInt($total);  
            $this->assertSame($item['expected'], $total);
            $cart->clear();
        }        
    }

    public function testCalculateTotalPriceForItemB(): void 
    {
        $checkout = new Checkout();
        $cart = new Cart();

        $items = [
            ['item' => 'B', 'qty' => 1, 'expected' => 30],
            ['item' => 'B', 'qty' => 2, 'expected' => 45],
            ['item' => 'B', 'qty' => 3, 'expected' => 75],
            ['item' => 'B', 'qty' => 4, 'expected' => 90],
            ['item' => 'B', 'qty' => 5, 'expected' => 120],
            ['item' => 'B', 'qty' => 6, 'expected' => 135],
        ];

        foreach ($items as $item) 
        {
            $cart->addItem($item['item'], $item['qty']);
            $cartItems = $cart->getItems();
            $total = $checkout->calculateTotalPrice($cartItems['items']); 
            $this->assertIsInt($total);  
            $this->assertSame($item['expected'], $total);
            $cart->clear();
        }        
    }

    public function testCalculateTotalPriceForItemC(): void 
    {
        $checkout = new Checkout();
        $cart = new Cart();

        $items = [
            ['item' => 'C', 'qty' => 1, 'expected' => 20],
            ['item' => 'C', 'qty' => 2, 'expected' => 38],
            ['item' => 'C', 'qty' => 3, 'expected' => 50],
            ['item' => 'C', 'qty' => 4, 'expected' => 70],
            ['item' => 'C', 'qty' => 5, 'expected' => 88],
            ['item' => 'C', 'qty' => 6, 'expected' => 100],
        ];

        foreach ($items as $item) 
        {
            $cart->addItem($item['item'], $item['qty']);
            $cartItems = $cart->getItems();
            $total = $checkout->calculateTotalPrice($cartItems['items']); 
            $this->assertIsInt($total);  
            $this->assertSame($item['expected'], $total);
            $cart->clear();
        }        
    }

    public function testCalculateTotalPriceForItemD(): void 
    {
        $checkout = new Checkout();
        $cart = new Cart();

        $items = [
            ['item' => 'A', 'qty' => 6, 'expected' => 260],
            ['item' => 'D', 'qty' => 10, 'expected' => 350],
        ];

        foreach ($items as $item) 
        {
            $cart->addItem($item['item'], $item['qty']);
            $cartItems = $cart->getItems();
            $total = $checkout->calculateTotalPrice($cartItems['items']); 
            $this->assertIsInt($total);  
            $this->assertSame($item['expected'], $total);
        }        
    }

    public function testCalculateTotalPriceForItemE(): void 
    {
        $checkout = new Checkout();
        $cart = new Cart();

        $items = [
            ['item' => 'E', 'qty' => 5, 'expected' => 25],
        ];

        foreach ($items as $item) 
        {
            $cart->addItem($item['item'], $item['qty']);
            $cartItems = $cart->getItems();
            $total = $checkout->calculateTotalPrice($cartItems['items']); 
            $this->assertIsInt($total);  
            $this->assertSame($item['expected'], $total);
        }        
    }

    public function testCalculateTotalPrice(): void 
    {
        $checkout = new Checkout();
        $cart = new Cart();

        $items = [
            ['item' => 'A', 'qty' => 3, 'expected' => 130],
            ['item' => 'B', 'qty' => 2, 'expected' => 175],
            ['item' => 'C', 'qty' => 5, 'expected' => 263],
            ['item' => 'D', 'qty' => 10, 'expected' => 383], 
            ['item' => 'E', 'qty' => 5, 'expected' => 408],
        ];

        foreach ($items as $item) 
        {
            $cart->addItem($item['item'], $item['qty']);
            $cartItems = $cart->getItems();
            $total = $checkout->calculateTotalPrice($cartItems['items']); 
            $this->assertIsInt($total);  
            $this->assertSame($item['expected'], $total);
        }        
    }
}