
scenario's


$adapter = PhpFsAdapter($settings);

$path = __DIR__;

$fm = new FileManager($adapter, $path);

// File

$fm->moveFile
$fm->addFile
$fm->removeFile
$fm->getFile
$fm->copyFile

// DIR

$fm->moveDir
$fm->addDir
$fm->removeDir
$fm->renameDir
$fm->readDir
$fm->findInDir

// issues

when content is created, we a correct handling method 
to store new content
fetch new content

it might be a good idea to look at fly system for example

We don't want to save in memory, we want to stream to file when content is created / updated