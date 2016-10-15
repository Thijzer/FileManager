<?php

namespace Tests\FileManager;

use FileManager\File;
use FileManager\FileManager;

class FileManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var FileManager */
    private $fileManager;

    public function setUp()
    {
        $this->fileManager = new FileManager(__DIR__ . '/test_dir');
    }

    /** @test */
    public function it_can_convert_following_spoon_template_file()
    {
        $filePath = __DIR__ . '/test_dir/test_file.php';
        $file = new File($filePath, file_get_contents($filePath));

        $this->fileManager->addFile($file);
        $this->fileManager->listDir();

        var_dump($this->fileManager->persist());

//        $spoonRecipe = new SpoonRecipe();
//        $newFile = $spoonRecipe->start($file, $this->converter);
//
//        $this->assertEquals(
//            $newFile->getContent(),
//            file_get_contents(__DIR__.'/twig_file/test_file.html.twig.test')
//        );
    }
}
