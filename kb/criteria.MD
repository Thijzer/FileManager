
# $fm = FileManager
# $adapter = Any supported Adapter

$criteria = new FSCriteria();

$criteria->filename->get('');
$criteria->filename->has('');
$criteria->filename->notHas('');

$criteria->filter($anonFunc);

$criteria->file->contentContains('');
$criteria->file->contentNotContains('');
$criteria->file->type('');
$criteria->file->size('');
$criteria->file->date('');

$criteria->path->get('');
$criteria->path->has('');
$criteria->path->notHas('');

$criteria->path->depth('');

$criteria->sort->byType('');
$criteria->sort->byName('');
$criteria->sort->bySize('');
$criteria->sort->byAccessed('');
$criteria->sort->byCreation('');
$criteria->sort->byModification('');

$fm->findFiles($criteria);