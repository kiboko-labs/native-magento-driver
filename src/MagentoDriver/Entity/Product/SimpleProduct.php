<?php

namespace Kiboko\Component\MagentoDriver\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Exception\RuntimeErrorException;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use Kiboko\Component\MagentoDriver\Model\SuperLinkInterface;

class SimpleProduct implements SimpleProductInterface
{
    use BaseProductTrait;

    /**
     * @var Collection
     */
    private $configurables;

    /**
     * @param string                  $stringIdentifier
     * @param FamilyInterface         $family
     * @param \DateTimeInterface|null $creationDate
     * @param \DateTimeInterface|null $modificationDate
     */
    public function __construct(
        $stringIdentifier,
        FamilyInterface $family = null,
        \DateTimeInterface $creationDate = null,
        \DateTimeInterface $modificationDate = null
    ) {
        $this->stringIdentifier = $stringIdentifier;
        $this->productType = ProductInterface::TYPE_SIMPLE;
        $this->family = $family;
        $this->values = new ArrayCollection();
        $this->configurables = new ArrayCollection();

        $this->creationDate = $this->initializeDate($creationDate);
        $this->modificationDate = $this->initializeDate($modificationDate);
    }

    /**
     * @param int                                  $identifier
     * @param string                               $stringIdentifier
     * @param FamilyInterface                      $family
     * @param \DateTimeInterface                   $creationDate
     * @param \DateTimeInterface                   $modificationDate
     * @param \Traversable|AttributeValueInterface[] $values
     *
     * @return static
     */
    public static function buildNewWith(
        $identifier,
        $stringIdentifier,
        FamilyInterface $family,
        \DateTimeInterface $creationDate,
        \DateTimeInterface $modificationDate,
        \Traversable $values = null
    ) {
        $instance = new self($stringIdentifier, $family, $creationDate, $modificationDate);

        $instance->identifier = $identifier;

        if ($values !== null) {
            /** @var AttributeValueInterface $value */
            foreach ($values as $value) {
                if (!$value instanceof AttributeValueInterface) {
                    throw new RuntimeErrorException(sprintf(
                        'Value shoud be an instqnce of %s, %s given.',
                        AttributeValueInterface::class,
                        is_object($value) ? get_class($value) : gettype($value)
                    ));
                }
                $instance->values->add($value->attachToProduct($instance));
            }
        }

        return $instance;
    }

    /**
     * @param ConfigurableProductInterface $configurable
     * @param SuperLinkInterface           $superLink
     */
    public function addToConfigurable(
        ConfigurableProductInterface $configurable,
        SuperLinkInterface $superLink
    ) {
        if (!$this->hasConfigurable($configurable)) {
            $this->configurables->set($configurable->getIdentifier(), $configurable);
            $configurable->addVariant($this);
        }
    }

    /**
     * @return Collection|ConfigurableProductInterface[]
     */
    public function getConfigurables()
    {
        return $this->configurables;
    }

    /**
     * @param ConfigurableProductInterface $configurable
     *
     * @return bool
     */
    public function hasConfigurable(ConfigurableProductInterface $configurable)
    {
        return $this->configurables->containsKey($configurable->getIdentifier());
    }

    /**
     * @return bool
     */
    public function hasConfigurables()
    {
        return $this->configurables->count() > 0;
    }

    public function getName()
    {
        //TODO: Fetch attribute's value
        return '';
    }
}
