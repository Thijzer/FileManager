<?php

namespace Utils;

class Functions
{
    public static function ArrayNewIndex($newIndex, array $records): array
    {
        $tmp = [];
        foreach ($records as $record) {
            if (isset($record[$newIndex]) && $index = $record[$newIndex]) {
                $tmp[$index] = $record;
            }
        }

        return $tmp;
    }
}