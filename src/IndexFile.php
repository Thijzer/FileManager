<?php

/*
 * This file is part of the File Manager.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src;

use src\File;

/**
 * @author Thijs De Paepe <thijs.dp@gmail.com>
 */
class IndexFile
{
    /**
     * @var array
     */
    private $index;
    private $files;
    public $changedFiles;

    /**
     * @var string
     */
    public $filename = '.index.json';

    /**
     * @var boolean
     */
    public $isChanged = false;

    /**
     * Construct
     *
     * @param string $directory
     */
    public function __construct($directory)
    {
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $this->index = new File($this->directory.$this->filename);
    }

    /**
     * Return all Index Files
     *
     * @return array array of Indexed Files
     */
    public function getFiles()
    {
        if (!$this->files) {
            $this->files = (array) @json_decode($this->index->getContent(), true);
        }
        return $this->files;
    }

    /**
     * @param  string Filename
     * @return File
     */
    public function getFile($filename)
    {
        $file = new File($this->directory.$filename);
        $fullPathHash = $file->getFullPathHash();
        return (isset($this->getFiles()[$fullPathHash])) ?
            $this->returnFile($this->getFiles()[$fullPathHash]):
            $file;
    }

    /**
     * Add a File to Index
     *
     * @param File $file
     */
    public function add(File $file)
    {
        # convert obj to array and store
        $hash = $file->getFullPathHash();
        $this->isChanged = true;
        $this->changedFiles[$hash] = $file;
        $file->getFileSize();
        $this->files[$hash] = json_decode(json_encode($file), true);
    }

    /**
     * Find a File in the Index
     *
     * @param  array   $needles
     * @param  bool    $sensitive
     * @param  integer $offset
     * @return array
     */
    public function find(array $needles, $sensitive = true, $offset = 0)
    {
        $result = [];
        foreach ($this->getFiles() as $fileInfo) {
            foreach ($needles as $needle) {
                $isFound = ($sensitive) ?
                    (strpos($fileInfo['filename'], $needle, $offset) !== false) :
                    (stripos($fileInfo['filename'], $needle, $offset) !== false);
                if ($isFound) {
                    $result[] =  $this->returnFile($fileInfo);
                }
            }
        }
        return $result;
    }

    /**
     * Save the Index File
     */
    public function save()
    {
        $this->index->setContent(json_encode($this->getFiles()))->save();
    }

    /**
     * Remove File from Index
     * @param  File   $file
     */
    public function remove(File $file)
    {
        $hash = $file->getFullPathHash();
        $this->isChanged = true;
        unset($this->files[$hash]);
    }

    /**
     * Returns a single File
     *
     * @param  array  $fileInfo set of properties
     * @return File   new File
     */
    public function returnFile(array $fileInfo)
    {
        return new File(
            $this->directory.$fileInfo['filename'],
            null,
            $fileInfo
        );
    }
}
