<?php 

declare (strict_types = 1);

require 'autoload.php';

class ItemPrice
{
    private static array $list = [
        [
            'sku' => 'A',
            'unit_price' => 50,
        ],
        [
            'sku' => 'B',
            'unit_price' => 30
        ],
        [
            'sku' => 'C',
            'unit_price' => 20
        ],
        [
            'sku' => 'D',
            'unit_price' => 15
        ],
        [
            'sku' => 'E',
            'unit_price' => 5
        ]
    ];

    public static function getItem(string $name): array
    {
        return Helper::filterList(self::$list, 'sku', $name);
    }
}