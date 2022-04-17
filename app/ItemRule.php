<?php 

declare (strict_types = 1);

require 'autoload.php';

class ItemRule implements RuleType
{
    private static array $rules = [
        [
            'sku' => 'A',
            'rule_type' => RuleType::SINGLE_ITEM_DISCOUNT,
            'rule' => [
                'quantity' => 3,
                'price' => 130
            ] 
        ],
        [
            'sku' => 'B',
            'rule_type' => RuleType::SINGLE_ITEM_DISCOUNT,
            'rule' => [
                'quantity' => 2,
                'price' => 45
            ] 
        ],
        [
            'sku' => 'C',
            'rule_type' => RuleType::MULTIPLE_ITEM_DISCOUNT,
            'rule' => [
                ['quantity' => 2, 'price' => 38],
                ['quantity' => 3, 'price' => 50],
            ] 
        ],
        [
            'sku' => 'D',
            'rule_type' => RuleType::DISCOUNTED_ITEM,
            'rule' => [
                'price' => 5,
                'discounted_item' => 'A' 
            ] 
        ],
    ];

    public static function getItem(string $name): array
    {
        return Helper::filterList(self::$rules, 'sku', $name);
    }
}