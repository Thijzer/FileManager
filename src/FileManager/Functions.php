<?php

function ArrayNewIndex($newIndex, array $records)
{
    $tmp = [];
    foreach ($records as $record) {
        if (isset($record[$newIndex]) && $index = $record[$newIndex]) {
            $tmp[$index] = $record;
        }
    }
    return $tmp;
}
