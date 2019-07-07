<?php

namespace File;

class SplFileCollection implements \Countable, \IteratorAggregate
{
    private $items;

    public function __construct(array $items = [])
    {
        $this->addFiles($items);
    }

    public function add($item): void
    {
        $this->items[] = $item;
    }

    public function addFiles($items): void
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * @return null|File
     */
    public function current()
    {
        $item = current($this->items);

        return $item ?: null;
    }

    /**
     * Execute a callback over each item.
     *
     * @param callable $callback
     */
    public function each(callable $callback): void
    {
        foreach ($this->items as $key => $item) {
            if (false === $callback($item, $key)) {
                break;
            }
        }
    }

    public function filter(callable $filter): self
    {
        return new self(array_filter($this->items, $filter));
    }

    public function map(callable $callback): self
    {
        $keys = array_keys($this->items);
        $items = array_map($callback, $this->items, $keys);
        return new self(array_combine($keys, $items));
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function hasItems(): bool
    {
        return $this->count() > 0;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }
}