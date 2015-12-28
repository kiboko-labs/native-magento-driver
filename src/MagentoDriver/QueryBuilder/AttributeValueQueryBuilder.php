<?php

namespace Luni\Component\MagentoDriver\QueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;

class AttributeValueQueryBuilder
    extends QueryBuilder
{
    /**
     * @var string
     */
    private $imageTableName;

    /**
     * @var string
     */
    private $localeTableName;

    public function updateMedia()
    {
        return $this
            ->update($this->imageTableName, 'i')
            ->innerJoin('i', $this->localeTableName, 'l', 'i.value_id=l.value_id')
            ->set('i.entity_id', '?1')
            ->set('i.attribute_id', '?2')
            ->set('i.value', '?3')
            ->set('l.label', '?4')
            ->set('l.position', '?5')
            ->where($this->expr()->eq('l.store_id', '?6'))
        ;
    }
}