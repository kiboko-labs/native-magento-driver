<?php

namespace Kiboko\Component\MagentoDriver\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Exception\RuntimeErrorException;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use Kiboko\Component\MagentoDriver\Model\ProductSuperAttribute;
use Kiboko\Component\MagentoDriver\Model\ProductSuperLink;
use Kiboko\Component\MagentoDriver\Model\SuperAttributeInterface;
use Kiboko\Component\MagentoDriver\Model\SuperLinkInterface;

class ConfigurableProduct implements ConfigurableProductInterface
{
    use BaseProductTrait;

    /**
     * @var Collection|SimpleProductInterface[]
     */
    private $variants;

    /**
     * @var Collection|SuperLinkInterface[]
     */
    private $superLinks;

    /**
     * @var Collection|AttributeInterface[]
     */
    private $axisAttributes;

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
        $this->productType = ProductInterface::TYPE_CONFIGURABLE;
        $this->family = $family;
        $this->values = new ArrayCollection();
        $this->axisAttributes = new ArrayCollection();
        $this->variants = new ArrayCollection();
        $this->superLinks = new ArrayCollection();

        $this->creationDate = $this->initializeDate($creationDate);
        $this->modificationDate = $this->initializeDate($modificationDate);
    }

    /**
     * @param int                                  $identifier
     * @param string                               $stringIdentifier
     * @param FamilyInterface                      $family
     * @param \DateTimeInterface                   $creationDate
     * @param \DateTimeInterface                   $modificationDate
     * @param Collection|AttributeValueInterface[] $values
     * @param Collection|AttributeInterface[]      $axisAttributes
     *
     * @return static
     */
    public static function buildNewWith(
        $identifier,
        $stringIdentifier,
        FamilyInterface $family,
        \DateTimeInterface $creationDate,
        \DateTimeInterface $modificationDate,
        Collection $values = null,
        Collection $axisAttributes = null
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

        if ($axisAttributes !== null) {
            /** @var AttributeValueInterface $attribute */
            foreach ($axisAttributes as $attribute) {
                if (!$attribute instanceof AttributeInterface) {
                    throw new RuntimeErrorException(sprintf(
                        'Value shoud be an instqnce of %s, %s given.',
                        AttributeInterface::class,
                        is_object($attribute) ? get_class($attribute) : gettype($attribute)
                    ));
                }
                $instance->axisAttributes->add($attribute);
            }
        }

        return $instance;
    }

    /**
     * @param AttributeInterface $superAttribute
     */
    public function addAxisAttribute(AttributeInterface $superAttribute)
    {
        $this->axisAttributes->add(new ProductSuperAttribute($superAttribute, $this));
    }

    /**
     * @param \Traversable|AttributeInterface[] $attributeList
     */
    public function addAxisAttributeList(\Traversable $attributeList)
    {
        foreach ($attributeList as $attribute) {
            $this->addAxisAttribute($attribute);
        }
    }

    /**
     * @return \Traversable|SuperAttributeInterface[]
     */
    public function getAxisAttributes()
    {
        return $this->axisAttributes;
    }

    /**
     * @param AttributeInterface $attribute
     *
     * @return bool
     */
    public function hasAxisAttribute(AttributeInterface $attribute)
    {
        /* @var SuperAttributeInterface $attribute */
        foreach ($this->axisAttributes as $superAttribute) {
            if ($superAttribute->isAttribute($attribute)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasAxisAttributes()
    {
        return $this->axisAttributes->count() > 0;
    }

    /**
     * @param SimpleProductInterface $variant
     */
    public function addVariant(SimpleProductInterface $variant)
    {
        if (!$this->hasVariant($variant)) {
            $superLink = new ProductSuperLink($this, $variant);
            $this->addSuperLink($superLink);

            $this->variants->set(spl_object_hash($variant), $variant);
            $variant->addToConfigurable($this, $superLink);
        }
    }

    /**
     * @param \Traversable|SimpleProductInterface[] $variants
     */
    public function addVariantList(\Traversable $variants)
    {
        foreach ($variants as $variant) {
            $this->addVariant($variant);
        }
    }

    /**
     * @param SimpleProductInterface $variant
     *
     * @return bool
     */
    public function hasVariant(SimpleProductInterface $variant)
    {
        return $this->variants->containsKey(spl_object_hash($variant));
    }

    /**
     * @return bool
     */
    public function hasVariants()
    {
        return $this->hasSuperLinks();
    }

    /**
     * @return \Traversable|SimpleProductInterface[]
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @param SuperLinkInterface $superLink
     */
    public function addSuperLink(SuperLinkInterface $superLink)
    {
        $this->superLinks->set(spl_object_hash($superLink), $superLink);
    }

    /**
     * @param \Traversable|SuperLinkInterface[] $superLinks
     */
    public function addSuperLinkList(\Traversable $superLinks)
    {
        foreach ($superLinks as $superLink) {
            $this->addSuperLink($superLink);
        }
    }

    /**
     * @param SuperLinkInterface $superLink
     *
     * @return bool
     */
    public function hasSuperLink(SuperLinkInterface $superLink)
    {
        return $this->superLinks->containsKey(spl_object_hash($superLink));
    }

    /**
     * @return bool
     */
    public function hasSuperLinks()
    {
        return $this->superLinks->count() > 0;
    }

    /**
     * @return \Traversable|SuperLinkInterface[]
     */
    public function getSuperLinks()
    {
        return clone $this->superLinks;
    }

    public function getName()
    {
        //TODO: Fetch attribute's value
        return '';
    }
}
