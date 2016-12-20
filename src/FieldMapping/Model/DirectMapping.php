<?php

namespace Kiboko\Component\FieldMapping\Model;

class DirectMapping implements MappingInterface, IdentifiableInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $target;

    /**
     * DirectMapping constructor.
     *
     * @param string $identifier
     * @param string $source
     * @param string $target
     */
    public function __construct($identifier, $source, $target)
    {
        $this->identifier = $identifier;
        $this->source = $source;
        $this->target = $target;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return DirectMapping
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return DirectMapping
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set target
     *
     * @param string $target
     *
     * @return DirectMapping
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }
}
