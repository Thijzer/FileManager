<?php

/*
 * This file is part of the File Manager.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src;

use src\IndexFile;
use src\File;

/**
 * @author Thijs De Paepe <thijs.dp@gmail.com>
 */
class FileManager
{
    private $indexFile;
    private $directory;
    private $systemFiles = ['.DS_Store', '@eaDir'];

    public function __construct($directory)
    {
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        if (!is_dir($this->directory)) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    /**
     * Returns a array of Directories
     * @return array
     */
    public function getDirectories()
    {
        return explode(DIRECTORY_SEPARATOR, $this->directory);
    }

    private function indexFile()
    {
        if (!$this->indexFile) {
            $this->indexFile = new IndexFile($this->directory);

            if (empty($this->indexFile->getFiles())) {
                $this->scan()->store();
            }

            // add your indexfile filename to the system Files
            $this->systemFiles[] = $this->indexFile->filename;
        }
        return $this->indexFile;
    }

    /**
     * Scans the Directory for Files
     */
    public function scan()
    {
        $indexFile = $this->indexFile();

        $foundFiles = array_diff(array_filter(scandir($this->directory), function ($item) {
            return !is_dir($this->directory.$item);
        }), $this->systemFiles);

        $files = Arrays::indexBy('filename', $indexFile->getFiles());
        $newFiles = array_diff($foundFiles, array_keys($files));
        $removedFiles = array_diff(array_keys($files), $foundFiles);

        foreach ($newFiles as $filename) {
            $indexFile->add(new File($this->directory.$filename));
        }
        foreach ($removedFiles as $filename) {
            $indexFile->remove(new File($this->directory.$filename));
        }

        return $this;
    }

    public function find(...$query)
    {
        return $this->indexFile()->find($query);
    }

    public function get($filename)
    {
        if ($file = $this->indexFile()->getFile($filename)) {
            return $file;
        }
        $file = new File($this->directory . $filename);
        if ($file->isFile()) {
            $this->addFile($file);
            return $file;
        }
        # not found
    }

    public function exists($filename)
    {
        return !empty(@$this->get($filename));
    }

    public function move($directory)
    {
        if ($this->indexFile()->isChanged) {
            $this->store();
        }
        if (is_dir($directory)) {
            return rename($this->directory, $directory);
        }
    }

    public function add($filename, $content)
    {
        $file = new File($this->directory.$filename, $content);
        $this->indexFile()->add($file);
        return $this;
    }

    public function remove($filename)
    {
        if ($file = $this->get($filename)) {
            $this->indexFile()->remove($file);
            $file->delete();
        }
    }

    public function store()
    {
        if ($this->indexFile()->isChanged) {
            $files = $this->indexFile()->changedFiles;
            foreach ($files as $file) {
                $file->save();
            }
            $this->indexFile()->save();
        }
        return $this;
    }

    public function getFileCount()
    {
        return count($this->indexFile()->getFiles());
    }

    public function getFiles($limit = 0, $offset = 0)
    {
        $tmp = [];
        $files = array_slice($this->indexFile()->getFiles(), $offset, $limit);
        foreach ($files as $hash => $file) {
            $tmp[$hash] = $this->indexFile()->returnFile($file);
        }
        return $tmp;
    }

    /**
     * Adds a File to the Index
     *
     * @param File $file [description]
     */
    private function addFile(File $file)
    {
        $this->indexFile()->add($file);
    }

    /**
     * md5 checksums of 2 files
     *
     * @param  File    $file1
     * @param  File    $file2
     * @return boolean
     */
    public function isIndentical(File $file1, File $file2)
    {
        return ($file1->getHash() === $file2->getHash());
    }
}

//
// public function buildPath(...$segments)
// {
//     return join(DIRECTORY_SEPARATOR, $segments);
// }
