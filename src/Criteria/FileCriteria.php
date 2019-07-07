<?php

namespace Criteria;

class FileCriteria
{
    private $contentContains = [];
    private $contentNotContains = [];
    private $type = [];
    private $size = [];
    private $date = [];

    public function contentContains(string $name): self
    {
        $this->contentContains[$name] = $name;

        return $this;
    }

    public function contentNotContains(string $name): self
    {
        $this->contentNotContains[$name] = $name;

        return $this;
    }

    public function type(string $name): self
    {
        $this->type[$name] = $name;

        return $this;
    }

    public function size(string $name): self
    {
        $this->size[$name] = $name;

        return $this;
    }

    public function date(string $name): self
    {
        $this->date[$name] = $name;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'contentContains' => array_values($this->contentContains),
            'contentNotContains' => array_values($this->contentNotContains),
            'type' => array_values($this->type),
            'size' => array_values($this->size),
            'data' => array_values($this->date),
        ];
    }
}
