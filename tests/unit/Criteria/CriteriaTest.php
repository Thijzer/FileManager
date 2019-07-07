<?php

namespace Tests\Criteria;

use Criteria\FSCriteria;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class CriteriaTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_check_if_a_file_can_be_found(): void
    {
        $criteria = new FSCriteria();

        $criteria->path()->depth($depth = '> 2');

        $data = $this->getExpectedData();
        $data['path']['depth'] = [$depth];

        $this->assertSame($data, $criteria->toArray());
    }
    
    private function getExpectedData(): array
    {
        return [
            'filename' => [
                'get' => [],
                'has' => [],
                'notHas' => [],
                'depth' => [],
            ],

            'file' => [
                'contentContains' => [],
                'contentNotContains' => [],
                'type' => [],
                'size' => [],
                'data' => [],
            ],

            'filter' => [],

            'path' => [
                'get' => [],
                'has' => [],
                'notHas' => [],
                'depth' => [],
            ],

            'sort' => [],
        ];
    }
}
