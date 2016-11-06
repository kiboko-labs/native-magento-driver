<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude('spec');

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(['-yoda_conditions', 'short_array_syntax', '-phpdoc_align'])
    ->finder($finder);

