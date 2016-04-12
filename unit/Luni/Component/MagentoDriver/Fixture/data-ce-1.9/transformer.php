<?php

require __DIR__ . '/../../../../../../vendor/autoload.php';

$files = new FilesystemIterator(
    __DIR__,
    FilesystemIterator::CURRENT_AS_FILEINFO |
    FilesystemIterator::SKIP_DOTS
);

$actualFileList = [
    'eav_entity_type',
    'eav_attribute_set',
    'eav_attribute',
    'core_website',
    'core_store_group',
    'core_store',
    'catalog_product_entity_varchar',
    'catalog_product_entity_text',
    'catalog_product_entity_int',
    'catalog_product_entity_decimal',
    'catalog_product_entity_datetime',
    'catalog_product_entity',
    'catalog_eav_attribute',
];

$data = [];

/** @var SplFileInfo $fileInfo */
foreach ($files as $fileInfo) {
    if (!in_array($fileInfo->getBasename('.csv'), $actualFileList)) {
        continue;
    }

    $table = $fileInfo->getBasename('.csv');
    $data[$table] = [];

    /** @var SplFileObject $file */
    $file = $fileInfo->openFile('r');

    $headers = $file->fgetcsv(',', '"');
    $headersCount = count($headers);
    while (!$file->eof()) {
        $line = $file->fgetcsv(',', '"');
        if ($headersCount != count($line)) {
            continue;
        }
        foreach ($line as &$field) {
            if (empty($field)) {
                $field = null;
            }
        }
        unset($field);
        $data[$table][] = array_combine($headers, $line);
    }
}

$yaml = new Symfony\Component\Yaml\Dumper();

file_put_contents(__DIR__ . '/dataset.yml', $yaml->dump($data, 3));