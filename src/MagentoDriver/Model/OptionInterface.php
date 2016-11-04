<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

interface OptionInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return int
     */
    public function getValue();

    /**
     * @return OptionLocaleInterface
     */
    public function getDefault();

    /**
     * @param int $storeId
     *
     * @return OptionLocaleInterface
     */
    public function getLocale($storeId);

    /**
     * @param int $storeId
     *
     * @return OptionLocaleInterface
     */
    public function getLocaleOrDefault($storeId);

    /**
     * @return string
     */
    public function getDefaultLabel();

    /**
     * @param int $storeId
     *
     * @return string
     */
    public function getLocaleLabel($storeId);

    /**
     * @param int $storeId
     *
     * @return string
     */
    public function getLocaleOrDefaultLabel($storeId);

    /**
     * @return OptionLocaleInterface
     */
    public function getAllLocales();
}
