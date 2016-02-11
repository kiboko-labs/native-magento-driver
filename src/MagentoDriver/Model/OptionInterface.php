<?php

namespace Luni\Component\MagentoDriver\Model;

interface OptionInterface
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
     * @return OptionLocaleInterface
     */
    public function getLocale($storeId);

    /**
     * @param int $storeId
     * @return OptionLocaleInterface
     */
    public function getLocaleOrDefault($storeId);

    /**
     * @return string
     */
    public function getDefaultLabel();

    /**
     * @param int $storeId
     * @return string
     */
    public function getLocaleLabel($storeId);

    /**
     * @param int $storeId
     * @return string
     */
    public function getLocaleOrDefaultLabel($storeId);

    /**
     * @return OptionLocaleInterface
     */
    public function getAllLocales();
}
