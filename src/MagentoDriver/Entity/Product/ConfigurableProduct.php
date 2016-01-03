<?php

namespace Luni\Component\MagentoDriver\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;

class ConfigurableProduct
    implements ProductInterface
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
        FamilyInterface $family,
        \DateTimeInterface $creationDate = null,
        \DateTimeInterface $modificationDate = null
    ) {
        $this->identifier = $identifier;
        $this->productType = 'configurable';
        $this->family = $family;
        $this->values = new ArrayCollection();

        if ($creationDate === null) {
            $this->creationDate = new \DateTimeImmutable();
        } else if ($creationDate instanceof \DateTime) {
            $this->creationDate = \DateTimeImmutable::createFromMutable($creationDate);
        } else {
            $this->creationDate = $creationDate;
        }

        if ($creationDate === null) {
            $this->modificationDate = new \DateTimeImmutable();
        } else if ($modificationDate instanceof \DateTime) {
            $this->modificationDate = \DateTimeImmutable::createFromMutable($modificationDate);
        } else {
            $this->modificationDate = $modificationDate;
        }
    }

    /**
     * @param int $id
     * @param string $identifier
     * @param FamilyInterface $family
     * @param \DateTimeInterface $creationDate
     * @param \DateTimeInterface $modificationDate
     * @return static
     */
    public static function buildNewWith(
        $id,
        $identifier,
        FamilyInterface $family,
        \DateTimeInterface $creationDate,
        \DateTimeInterface $modificationDate
    ) {
        $instance = new static($identifier, $family, $creationDate, $modificationDate);

        $instance->id = $id;

        return $instance;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->productType;
    }
}