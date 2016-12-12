<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

class Store implements StoreInterface
{
    use MappableTrait;
    use IdentifiableTrait;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * Store constructor.
     *
     * @param int    $code
     * @param string $name
     */
    public function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int    $identifier
     * @param string $code
     * @param string $name
     *
     * @return static
     */
    public static function buildNewWith($identifier, $code, $name = null)
    {
        $object = new static($code, $name);

        $object->persistedToId($identifier);

        return $object;
    }
}
