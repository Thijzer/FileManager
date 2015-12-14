<?php

/**
 * You could hang me for this, I will understand
 * but using global functions is a part of PHP's nature.
 * You could join in or avoid at all costs.
 *
 * For me it can be done, but there are rules :
 * - if it's usefull saves time
 * - as long as you don't expose secrets globally
 * - as the function does what it says
 * - as long as it only relies on it's parameters
 * - if it has no other place then it's own
 */

/**
 * Returns the array with a new index
 *
 * @param string $newIndex  the new index
 * @param array  $records
 *
 * @return array
 */
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
