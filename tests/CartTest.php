<?php 

declare(strict_types=1);

require 'autoload.php';

use PHPUnit\Framework\TestCase;

final class CartTest extends TestCase 
{
    public function testAddItem(): void 
    {
        $cart = new Cart();
        $cart->addItem('A', 3);
        $cartItems = $cart->getItems();

        $this->assertIsArray($cartItems);
        $this->assertArrayHasKey('items', $cartItems);
        $this->assertIsArray($cartItems['items'] ?? null);
        $this->assertArrayHasKey('item', $cartItems['items'][0]);
        $this->assertArrayHasKey('quantity', $cartItems['items'][0]);
        $this->assertSame('A', $cartItems['items'][0]['item']);
        $this->assertSame(3, $cartItems['items'][0]['quantity']);
    }
}