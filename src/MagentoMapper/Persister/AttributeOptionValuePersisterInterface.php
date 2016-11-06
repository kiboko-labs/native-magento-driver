<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Persister;

interface AttributeOptionValuePersisterInterface
{
    /**
     * @param string $optionsCode
     * @param string $locale
     * @param int    $identifier
     */
    public function persist($optionsCode, $locale, $identifier);

    public function flush();
}
