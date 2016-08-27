<?php

namespace Kiboko\Component\MagentoDriver\Model;

class Store
{
    use MappableTrait;

    /**
     * @var int
     */
    private $identifier;

    /**
     * @var string
     */
    private $code;

    /**
     * Store constructor.
     * @param int $identifier
     * @param string $code
     */
    public function __construct($identifier, $code)
    {
        $this->identifier = $identifier;
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
