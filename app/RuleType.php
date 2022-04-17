<?php 

declare (strict_types = 1);

interface RuleType 
{
    public const SINGLE_ITEM_DISCOUNT = 1;
    public const MULTIPLE_ITEM_DISCOUNT = 2;
    public const DISCOUNTED_ITEM = 3;
}