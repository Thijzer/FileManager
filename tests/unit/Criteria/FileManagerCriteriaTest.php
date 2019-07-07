<?php

namespace Tests\Criteria;

use Criteria\FSCriteria;
use File\File;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class FileManagerCriteriaTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_find_files_on_wildcard_name(): void
    {
        $criteria = new FSCriteria();

        $criteria->filename()->has( '*.txt')->has('*.jpg');

        $fm = new \FileManager\FileManager(__DIR__);

        $files = $fm->findFiles($criteria);

        $this->assertCount(3, $files);
    }

    /**
     * @test
     */
    public function it_should_find_files_on_wildcard_path(): void
    {
        $criteria = new FSCriteria();

        $criteria->path()->has( 'files/*');

        $fm = new \FileManager\FileManager(__DIR__);

        $files = $fm->findFiles($criteria);

        $this->assertCount(3, $files);
    }

    /**
     * @test
     */
    public function it_should_find_files_without_wildcard_path(): void
    {
        $criteria = new FSCriteria();

        $criteria->path()->notHasName( 'files/*');

        $fm = new \FileManager\FileManager(__DIR__);

        $files = $fm->findFiles($criteria);

        $this->assertCount(0, $files->filter(function(File $file) {
            return strpos($file->getPath(), 'files') !== false;
        })->getItems());
    }

    /**
     * @test
     */
    public function it_should_find_files_without_wildcard_name(): void
    {
        $criteria = new FSCriteria();

        $criteria->filename()->notHasName( '*.txt');

        $fm = new \FileManager\FileManager(__DIR__);

        $files = $fm->findFiles($criteria);

        $this->assertCount(0, $files->filter(function(File $file) {
            return strpos($file->getPath(), 'txt') !== false;
        }));
    }

    /**
     * @test
     */
    public function it_should_combine_different_options_name(): void
    {
        $criteria = new FSCriteria();

        $criteria->filename()->has( '*.txt')->notHasName('test2.*');
        $criteria->path()->has( 'files/*');

        $fm = new \FileManager\FileManager(__DIR__);

        $files = $fm->findFiles($criteria);

        $file = $files->current();

        $this->assertCount(1, $files);

        $this->assertSame('files/test.txt', $file->getPath());
    }
}
