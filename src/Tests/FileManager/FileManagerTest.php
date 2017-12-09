<?php

namespace Tests\FileManager;

use FileManager\File;
use FileManager\FileManager;
use FileManager\Commands\CommandRecorder;

class FileManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var FileManager */
    private $fileManager;
    /** @var CommandRecorder */
    private $recorder;

    public function setUp()
    {
        $this->recorder = new CommandRecorder();
        $this->fileManager = new FileManager(
            __DIR__ . '/test_dir',
            $this->recorder
        );
    }

    /** @test */
    public function it_can_convert_following_spoon_template_file()
    {
        $filePath = __DIR__ . '/test_dir/test_file.php';
        $file = new File($filePath, file_get_contents($filePath));

        // $this->fileManager->addFile($file);
        // $this->fileManager->listDir();

        // $a = $this->recorder->getRecordedCommands();
        // \var_dump(
        //     count($a),
        //     count($this->recorder->getRecordedCommands())
        // );

        // array_map(function ($record) {
        //     \var_dump(
        //         $record->getAction(),
        //         $record->getAsset() instanceof File,
        //         $record->getResolution()
        //     );
        // }, $a);

        $this->fileManager->addFile($file);
        $this->fileManager->listDir();

        $this->fileManager->persist();
    }
}
