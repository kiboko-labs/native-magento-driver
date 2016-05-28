<?php

namespace Kiboko\Component\MagentoDriver\Filesystem;

use Doctrine\Common\Collections\Collection;
use League\Flysystem\File;
use League\Flysystem\FilesystemInterface;

class StandardFileMover implements FileMoverInterface
{
    public function move(
        FilesystemInterface $source,
        FilesystemInterface $destination,
        Collection $pathList
    ) {
        /** @var File $path */
        foreach ($pathList as $path) {
            if (($stream = $source->readStream($path)) === false) {
                continue;
            }
            $destination->putStream($path, $stream);
        }
    }
}
