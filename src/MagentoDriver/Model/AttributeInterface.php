<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

interface AttributeInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return int
     */
    public function getEntityTypeId();

    /**
     * @return string
     */
    public function getCode();

    /**
     * @return string
     */
    public function getModelClass();

    /**
     * @return string
     */
    public function getBackendType();

    /**
     * @return string
     */
    public function getBackendModelClass();

    /**
     * @return string
     */
    public function getBackendTable();

    /**
     * @return string
     */
    public function getFrontendModelClass();

    /**
     * @return string
     */
    public function getFrontendInput();

    /**
     * @return string
     */
    public function getFrontendLabel();

    /**
     * @return string
     */
    public function getFrontendViewClass();

    /**
     * @return string
     */
    public function getSourceModelClass();

    /**
     * @return bool
     */
    public function isRequired();

    /**
     * @return bool
     */
    public function isUserDefined();

    /**
     * @return bool
     */
    public function isSystem();

    /**
     * @return bool
     */
    public function isUnique();

    /**
     * @return string
     */
    public function getDefaultValue();

    /**
     * @return string
     */
    public function getNote();
}
