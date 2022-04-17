<?php 

declare (strict_types = 1);

require 'autoload.php';

trait DiscountCalculator 
{
    public function hasSingleDiscountOffer(array $itemRule): bool
    {
        return $itemRule['rule_type'] === RuleType::SINGLE_ITEM_DISCOUNT;
    }   

    public function hasMultipleDiscountOffer(array $itemRule): bool 
    {
        return $itemRule['rule_type'] === RuleType::MULTIPLE_ITEM_DISCOUNT;
    }

    public function hasDiscountedItemOffer(array $itemRule): bool 
    {
        return $itemRule['rule_type'] === RuleType::DISCOUNTED_ITEM;
    }

    public function calculateGroupQuantity(int $firstQty, int $secondQty): int 
    {
        return (int) ($firstQty / $secondQty);
    }

    public function calculateExtraQuantity(int $firstQty, int $secondQty): int 
    {
        return (int) ($firstQty % $secondQty);
    }

    public function calculateQuantityPrice(
        int $cartQty, 
        int $itemQty, 
        int $itemPrice, 
        int $unitPrice
    ): int 
    {
        $groupQty = $this->calculateGroupQuantity($cartQty, $itemQty);
        $extraQty = $this->calculateExtraQuantity($cartQty, $itemQty);
        $groupQtyPrice = Helper::product($groupQty, $itemPrice);
        $extraQtyPrice = Helper::product($extraQty, $unitPrice);
        return Helper::sum($groupQtyPrice, $extraQtyPrice);
    } 

    public function calculateMultipleQuantityPrice(
        int $cartQty, 
        int $firstItemQty, 
        int $secondItemQty, 
        int $firstItemPrice, 
        int $secondItemPrice, 
        int $unitPrice
    ): int
    {
        $groupQty = $this->calculateGroupQuantity($cartQty, $firstItemQty);
        $extraQty = $this->calculateExtraQuantity($cartQty, $firstItemQty);
        $groupQtyPrice = Helper::product($groupQty, $firstItemPrice);
        $extraQtyPrice = 0;
        
        if (Helper::equals($extraQty, $firstItemQty))
            $extraQtyPrice = $firstItemPrice;

        else if (Helper::equals($extraQty, $secondItemQty))
            $extraQtyPrice = $secondItemPrice;

        else 
            $extraQtyPrice = Helper::product($extraQty, $unitPrice);

        return Helper::sum($groupQtyPrice, $extraQtyPrice);
    }

    public function calculateSingleDiscountPrice(array $cartItem, array $itemRule, array $itemPrice): int
    {
        $cartItemQuantity = $cartItem['quantity'];
        $itemRuleQuantity = $itemRule['rule']['quantity'];
        $itemRulePrice    = $itemRule['rule']['price'];
        $perUnitPrice     = $itemPrice['unit_price'];

        if (Helper::equals($cartItemQuantity, $itemRuleQuantity)) 
            return $itemRulePrice;

        if (Helper::greater($cartItemQuantity, $itemRuleQuantity)) {
            return $this->calculateQuantityPrice(
                $cartItemQuantity,
                $itemRuleQuantity,
                $itemRulePrice,
                $perUnitPrice
            );
        }

        return Helper::product($cartItemQuantity, $perUnitPrice);

    }

    public function calculateCheapestDiscountPrice(array $cartItem, array $itemRule, array $itemPrice): int 
    {
        $cartItemQuantity       = $cartItem['quantity'];
        $firstItemRuleQuantity  = $itemRule['rule'][0]['quantity'];
        $firstItemRulePrice     = $itemRule['rule'][0]['price'];
        $secondItemRuleQuantity = $itemRule['rule'][1]['quantity'];
        $secondItemRulePrice    = $itemRule['rule'][1]['price'];
        $perUnitPrice           = $itemPrice['unit_price'];  
        
        if (Helper::equals($cartItemQuantity, $firstItemRuleQuantity)) 
            return $firstItemRulePrice;
        
        if (Helper::equals($cartItemQuantity, $secondItemRuleQuantity))
            return $secondItemRulePrice;

        if (
            Helper::greater($cartItemQuantity, $firstItemRuleQuantity) &&
            Helper::greater($cartItemQuantity, $secondItemRuleQuantity)
        )
        {
            $firstTotalPrice = $this->calculateMultipleQuantityPrice(
                $cartItemQuantity,
                $firstItemRuleQuantity,
                $secondItemRuleQuantity,
                $firstItemRulePrice,
                $secondItemRulePrice,
                $perUnitPrice
            );
            
            $secondTotalPrice = $this->calculateMultipleQuantityPrice(
                $cartItemQuantity,
                $secondItemRuleQuantity,
                $firstItemRuleQuantity,
                $secondItemRulePrice,
                $firstItemRulePrice,
                $perUnitPrice
            );

            return min([$firstTotalPrice, $secondTotalPrice]);
        }

        return Helper::product($cartItemQuantity, $perUnitPrice);
    }

    public function calculateDiscountedItemPrice(
        array $cartItem, 
        array $filteredItem, 
        array $itemRule, 
        array $itemPrice
    ): int 
    {
        $filteredItemQty = $filteredItem['quantity'];
        $cartItemQty = $cartItem['quantity'];
        $unitPrice = $itemPrice['unit_price'];
        $itemRulePrice = $itemRule['rule']['price'];

        $extraQty = ($cartItemQty > $filteredItemQty) ? ($cartItemQty - $filteredItemQty) : 0;
        $discountedQty = $cartItemQty - $extraQty;
        $extraQtyPrice = $extraQty * $unitPrice;
        $discountedQtyPrice = $discountedQty * $itemRulePrice;
        
        return Helper::sum($discountedQtyPrice, $extraQtyPrice);
    }
}