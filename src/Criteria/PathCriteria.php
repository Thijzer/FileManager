<?php

namespace Criteria;

class PathCriteria
{
    private $get = [];
    private $has = [];
    private $notHas = [];
    private $depth = [];

    public function get(string $name): self
    {
        $this->get[$name] = $name;

        return $this;
    }

    public function has(string $name): self
    {
        $this->has[$name] = $name;

        return $this;
    }

    public function notHasName(string $name): self
    {
        $this->notHas[$name] = $name;

        return $this;
    }

    public function depth(string $name): self
    {
        $this->depth[$name] = $name;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'get' => array_values($this->get),
            'has' => array_values($this->has),
            'notHas' => array_values($this->notHas),
            'depth' => array_values($this->depth),
        ];
    }
}

