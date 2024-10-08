<?php

function condition(array $arr, string $currentCategory): bool
{
    $checkCategory = $currentCategory == $arr['categories_id'] || $currentCategory === 'all';

    return $arr['published'] && $checkCategory;
}