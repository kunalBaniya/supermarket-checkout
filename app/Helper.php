<?php 

declare (strict_types = 1);

class Helper 
{
    public static function filterList(array $list, string $key, string $filterKey): array
    { 
        $filteredItem = array_filter($list, function ($item) use ($key, $filterKey) {
            return $item[$key] === $filterKey;
        });

        return $filteredItem ? array_values($filteredItem)[0] : [];
    }

    public static function equals(int $first, int $second): bool
    {
        return $first === $second;
    }

    public static function greater(int $first, int $second): bool 
    {
        return $first > $second;
    }

    public static function product(int $first, int $second): int 
    {
        return $first * $second;
    }

    public static function extractFromArray(array $array, $key): array 
    {
        return array_column($array, $key);
    }

    public static function sum(int $first, int $second): int 
    {
        return $first + $second;
    }
}