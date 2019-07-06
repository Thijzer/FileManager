<?php
/*
 *  This file is property of
 *
 *  (c) Thijs De Paepe <thijs.dp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Induxx\Component\Utils;
use File\File;
use File\FilePath;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class FileManagerTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_check_if_a_file_can_be_found(): void
    {
        $fm = new \FileManager\FileManager(__DIR__);

        $this->assertTrue($fm->isFile('files/test.txt'));

        $this->assertFalse($fm->isFile('files/no_test.txt'));
    }

    /**
     * @test
     */
    public function it_should_get_a_file_by_filename(): void
    {
        $fm = new \FileManager\FileManager(__DIR__);

        $file = $fm->getFile('files/test.txt');

        $this->assertTrue($file->getFilePath()->is('files/test.txt'));
    }

    /**
     * @test
     */
    public function it_should_find_files_by_filename(): void
    {
        $fm = new \FileManager\FileManager(__DIR__);

        $files = $fm->findFiles('files/');

        $file = $files->current();

        $this->assertTrue($file->getFilePath()->is('files/test.txt'));
    }

    /**
     * @test
     */
    public function it_should_rename_by_filename(): void
    {
        $fm = new \FileManager\FileManager(__DIR__);

        $fm->renameFile('files/test.txt', 'files/test.md');

        $this->assertTrue($fm->isFile('files/test.md'));

        $this->assertFalse($fm->isFile('files/test.txt'));

        rename(__DIR__.'/files/test.md', __DIR__.'/files/test.txt');
    }

    /**
     * @test
     */
    public function it_should_remove_by_filename(): void
    {
        $fm = new \FileManager\FileManager(__DIR__);

        $file = new File(new FilePath('files/test.md'));

        $fm->addFile($file);

        $fm->removeFile('files/test.md');

        $this->assertFalse($fm->isFile('files/test.md'));
    }

    /**
     * @test
     */
    public function it_should_create_by_filename(): void
    {
        $fm = new \FileManager\FileManager(__DIR__);

        $file = new File(new FilePath('files/test.md'));

        $fm->addFile($file);

        $this->assertTrue($fm->isFile('files/test.md'));
    }

    /**
     * @test
     */
    public function it_should_copy_by_filename(): void
    {
        $fm = new \FileManager\FileManager(__DIR__);

        $fm->copyFile('files/test.txt', 'files/test.md');

        $this->assertTrue($fm->isFile('files/test.md'));

        unlink(__DIR__.'/files/test.md');
    }
}