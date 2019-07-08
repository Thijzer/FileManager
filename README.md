
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


// TODO's

- add pagination
- add sorting
- add date type size + human  readable converter
- add directory instructions
- add AWS adapter
- add FTP adapter
- add SFTP adapter
- add DB adapter 
- add FSadapter + indexer (some kind of caching mechanism, for search and file info)
- add adapter syncronizer (keep 2 adapters in sync with command)
     - tip : use recorded messages and replay them on a connected adapter
     - tip : let adapters connect in a master slave pattern
- store recorded messages and try to replay them
 - store in DB
 - store in storage_container
- history fast forward / rewind - files