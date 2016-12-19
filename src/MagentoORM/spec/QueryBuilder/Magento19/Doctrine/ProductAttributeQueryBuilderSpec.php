<?php

namespace spec\Kiboko\Component\MagentoORM\QueryBuilder\V1_9ce\Doctrine;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;

class ProductAttributeQueryBuilderSpec extends ObjectBehavior
{
    public function it_is_initializable(Connection $connection)
    {
        $this->beConstructedWith($connection, 'main_table', 'extra_table', 'entity_table', 'variant_axis_table', 'family_table', [], []);
        $this->shouldHaveType('Kiboko\Component\MagentoORM\QueryBuilder\V1_9ce\Doctrine\ProductAttributeQueryBuilder');
    }
}
