<?php

namespace Luni\Component\MagentoDriver\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;
use Luni\Component\MagentoDriver\Model\SuperLinkInterface;

class SimpleProduct implements SimpleProductInterface
{
    use BaseProductTrait;

    /**
     * @var Collection
     */
    private $configurables;

    /**
     * @param string                  $identifier
     * @param FamilyInterface         $family,
     * @param \DateTimeInterface|null $creationDate
     * @param \DateTimeInterface|null $modificationDate
     */
    public function __construct(
        $identifier,
        FamilyInterface $family = null,
        \DateTimeInterface $creationDate = null,
        \DateTimeInterface $modificationDate = null
    ) {
        $this->identifier = $identifier;
        $this->productType = ProductInterface::TYPE_SIMPLE;
        $this->family = $family;
        $this->values = new ArrayCollection();
        $this->configurables = new ArrayCollection();

        $this->creationDate = $this->initializeDate($creationDate);
        $this->modificationDate = $this->initializeDate($modificationDate);
    }

    /**
     * @param int                                  $id
     * @param string                               $identifier
     * @param FamilyInterface                      $family
     * @param \DateTimeInterface                   $creationDate
     * @param \DateTimeInterface                   $modificationDate
     * @param Collection|AttributeValueInterface[] $values
     *
     * @return static
     */
    public static function buildNewWith(
        $id,
        $identifier,
        FamilyInterface $family,
        \DateTimeInterface $creationDate,
        \DateTimeInterface $modificationDate,
        Collection $values = null
    ) {
        $instance = new self($identifier, $family, $creationDate, $modificationDate);

        $instance->id = $id;

        if ($values !== null) {
            /** @var AttributeValueInterface $value */
            foreach ($values as $value) {
                if (!$value instanceof AttributeValueInterface) {
                    throw new RuntimeErrorException(sprintf(
                        'Value shoud be an instqnce of %s, %s given.',
                        AttributeValueInterface::class,
                        get_class($value)
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
}
