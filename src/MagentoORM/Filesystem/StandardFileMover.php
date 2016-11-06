<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Filesystem;

use League\Flysystem\File;
use League\Flysystem\FilesystemInterface;

class StandardFileMover implements FileMoverInterface
{
    public function move(
        FilesystemInterface $source,
        FilesystemInterface $destination,
        \Traversable $pathList
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
