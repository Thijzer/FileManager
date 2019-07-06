<?php

namespace Criteria;

class SortCriteria
{
    public const SORT_BY_TYPE = 'sortByType';
    public const SORT_BY_NAME = 'sortByName';
    public const SORT_BY_SIZE = 'sortBySize';
    public const SORT_BY_ACCESSED = 'sortByAccessed';
    public const SORT_BY_CREATION = 'sortByCreation';
    public const SORT_BY_MODIFICATION = 'sortByModification';

    private $sort = [];

    public function byType(): self
    {
        $this->sort[] = self::SORT_BY_TYPE;

        return $this;
    }

    public function byName(): self
    {
        $this->sort[] = self::SORT_BY_TYPE;

        return $this;
    }

    public function bySize(): self
    {
        $this->sort[] = self::SORT_BY_TYPE;

        return $this;
    }

    public function byAccessed(): self
    {
        $this->sort = [self::SORT_BY_ACCESSED];

        return $this;
    }

    public function byCreation(): self
    {
        $this->sort = [self::SORT_BY_CREATION];

        return $this;
    }

    public function byModification(): self
    {
        $this->sort = [self::SORT_BY_MODIFICATION];

        return $this;
    }

    public function getSort(): array
    {
        return $this->sort;
    }
}
