<?php

namespace Criteria\Filter;

use Criteria\FSCriteria;
use File\File;

class FilterBuilder
{
    /**
     * @param FSCriteria $criteria
     * @return []|closure[]
     */
    public static function buildFromCriteria(FSCriteria $criteria): array
    {
        $filters = [];

        $flatCriteria = $criteria->filename()->toArray();
        if (\count($flatCriteria['has']) > 0) {
            foreach ($flatCriteria['has'] as $hasCriteria) {
                $filters['filenameHas'][] = function (File $filename) use ($hasCriteria) {
                    return fnmatch($hasCriteria, $filename->getName());
                    //return preg_match(sprintf('/^%s/', $hasCriteria), $filename);
                };
            }
        }
        if (\count($flatCriteria['notHas']) > 0) {
            foreach ($flatCriteria['notHas'] as $hasCriteria) {
                $filters['filenameNotHas'][] = function (File $filename) use ($hasCriteria) {
                    return false === fnmatch($hasCriteria, $filename->getName());
                };
            }
        }

        $flatCriteria = $criteria->path()->toArray();
        if (\count($flatCriteria['has']) > 0) {
            foreach ($flatCriteria['has'] as $hasCriteria) {
                $filters['pathHas'][] = function (File $filename) use ($hasCriteria) {
                    return fnmatch($hasCriteria, $filename->getPath());
                };
            }
        }

        if (\count($flatCriteria['notHas']) > 0) {
            foreach ($flatCriteria['notHas'] as $hasCriteria) {
                $filters['pathNotHas'][] = function (File $filename) use ($hasCriteria) {
                    return false === fnmatch($hasCriteria, $filename->getPath());
                };
            }
        }

        return $filters;
    }
}