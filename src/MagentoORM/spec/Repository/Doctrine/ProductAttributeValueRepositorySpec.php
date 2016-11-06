<?php

namespace spec\Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Factory\AttributeValueFactoryInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilderInterface;
use Kiboko\Component\MagentoORM\Repository\AttributeRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductAttributeValueRepositorySpec extends ObjectBehavior
{
    function it_is_initializable(
        Connection $connection,
        ProductAttributeValueQueryBuilderInterface $queryBuilder,
        AttributeRepositoryInterface $attributeRepository,
        AttributeValueFactoryInterface $valueFactory
    ) {
        $this->beConstructedWith($connection, $queryBuilder, $attributeRepository, $valueFactory);
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Repository\Doctrine\ProductAttributeValueRepository');
    }
}
