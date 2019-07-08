<?php

namespace spec\File;

use File\File;
use File\FilePath;
use FileManager\FileManager;
use PhpSpec\ObjectBehavior;

class FileSpec extends ObjectBehavior
{
    function let(FilePath $filePath)
    {
        $filePath->getPath()->willReturn('path');

        $this->beConstructedWith($filePath);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(File::class);
    }

    function it_should_create_from_splFileInfo(\SplFileInfo $fileInfo)
    {
        $this->beConstructedThrough('createFromSpfFileInfo', [
            $fileInfo
        ]);
    }
}
