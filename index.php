<?php

require 'autoload.php';

$cart = new Cart();

//$cart->addItem('A', 6);
//$cart->addItem('C', 5);
//$cart->addItem('D', 10);
$cart->addItem('E', 5);

$cartItems = $cart->getItems();

$checkout = new Checkout();

echo $checkout->calculateTotalPrice($cartItems['items']);