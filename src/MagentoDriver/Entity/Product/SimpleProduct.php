<?php

namespace Luni\Component\MagentoDriver\Entity\Product;

use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;

class SimpleProduct
    implements ProductInterface
{
    use BaseProductTrait;

    /**
     * @param string $identifier
     * @param FamilyInterface $family,
     * @param \DateTimeInterface $creationDate
     * @param \DateTimeInterface $modificationDate
     */
    public function __construct(
        $identifier,
        FamilyInterface $family,
        \DateTimeInterface $creationDate,
        \DateTimeInterface $modificationDate
    ) {
        $this->identifier = $identifier;
        $this->productType = 'simple';
        $this->family = $family;

        if ($creationDate instanceof \DateTime) {
            $this->creationDate = \DateTimeImmutable::createFromMutable($creationDate);
        } else {
            $this->creationDate = $creationDate;
        }

        if ($modificationDate instanceof \DateTime) {
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