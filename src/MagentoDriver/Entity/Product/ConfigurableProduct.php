<?php

namespace Luni\Component\MagentoDriver\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;

class ConfigurableProduct
    implements ConfigurableProductInterface
{
    use BaseProductTrait;

    /**
     * @param string $identifier
     * @param FamilyInterface $family,
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
        $this->productType = 'configurable';
        $this->family = $family;
        $this->values = new ArrayCollection();
        $this->axisAttributes = new ArrayCollection();

        $this->creationDate = $this->initializeDate($creationDate);
        $this->modificationDate = $this->initializeDate($modificationDate);
    }

    /**
     * @param AttributeInterface $attribute
     */
    public function addAxisAttribute(AttributeInterface $attribute)
    {
        $this->axisAttributes->add($attribute);
    }

    /**
     * @param Collection|AttributeInterface[] $attributeList
     */
    public function addAxisAttributeList(Collection $attributeList)
    {
        foreach ($attributeList as $attribute) {
            $this->addAxisAttribute($attribute);
        }
    }

    /**
     * @param int $id
     * @param string $identifier
     * @param FamilyInterface $family
     * @param \DateTimeInterface $creationDate
     * @param \DateTimeInterface $modificationDate
     * @param Collection|AttributeValueInterface[] $values
     * @param Collection|AttributeInterface[] $attributes
     * @return static
     */
    public static function buildNewWith(
        $id,
        $identifier,
        FamilyInterface $family,
        \DateTimeInterface $creationDate,
        \DateTimeInterface $modificationDate,
        Collection $values = null,
        Collection $attributes = null
    ) {
        $instance = new self($identifier, $family, $creationDate, $modificationDate);

        $instance->id = $id;

        if ($values !== null) {
            /** @var AttributeValueInterface $value */
            foreach ($values as $value) {
                $instance->values->add($value->attachToProduct($instance));
            }
        }

        if ($attributes !== null) {
            /** @var AttributeValueInterface $attribute */
            foreach ($attributes as $attribute) {
                $instance->values->add($attribute);
            }
        }

        return $instance;
    }
}
