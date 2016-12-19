<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace spec\Kiboko\Component\MagentoORM\QueryBuilder\V2_0ce\Doctrine;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;

class ProductAttributeQueryBuilderSpec extends ObjectBehavior
{
    public function it_is_initializable(Connection $connection)
    {
        $this->beConstructedWith($connection, 'main_table', 'extra_table', 'entity_table', 'variant_axis_table', 'family_table', [], []);
        $this->shouldHaveType('Kiboko\Component\MagentoORM\QueryBuilder\V2_0ce\Doctrine\ProductAttributeQueryBuilder');
    }
}
