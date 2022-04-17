<?php

declare (strict_types = 1);

require 'autoload.php';

class Checkout 
{
    use DiscountCalculator;

    public function calculateTotalPrice(array $cartItems): int
    {
        $total = 0.0;

        foreach ($cartItems as $cartItem)
        {
            $itemName  = $cartItem['item'];
            $itemQty   = $cartItem['quantity'];
            $itemPrice = ItemPrice::getItem($itemName);
            $itemRule  = ItemRule::getItem($itemName);

            if ($itemRule) 
            {
                if ($this->hasSingleDiscountOffer($itemRule)) {  
                    $total += $this->calculateSingleDiscountPrice($cartItem, $itemRule, $itemPrice);
                }
                else if ($this->hasMultipleDiscountOffer($itemRule)) {
                    $total += $this->calculateCheapestDiscountPrice($cartItem, $itemRule, $itemPrice);
                }
                else if ($this->hasDiscountedItemOffer($itemRule)) {
                    $cartItemNames = Helper::extractFromArray($cartItems, 'item');
                    $discountedItemName = $itemRule['rule']['discounted_item'];
                    $filteredItem = [];
                    
                    if (in_array($itemRule['rule']['discounted_item'], $cartItemNames)) 
                        $filteredItem = Helper::filterList($cartItems, 'item', $discountedItemName);
                  
                    $total += ($filteredItem) 
                        ? $this->calculateDiscountedItemPrice($cartItem, $filteredItem, $itemRule, $itemPrice)
                        : Helper::product($itemQty, $itemPrice['unit_price']);
                }
            }
            else
            {
                $total += Helper::product($itemQty, $itemPrice['unit_price']);
            }
        }

        return (int) $total;
    }
}