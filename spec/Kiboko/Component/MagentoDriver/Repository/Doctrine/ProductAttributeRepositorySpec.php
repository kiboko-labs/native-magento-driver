<?php

namespace spec\Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Factory\ProductAttributeValueFactoryInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductAttributeRepositorySpec extends ObjectBehavior
{
    function it_is_initializable(
        Connection $connection,
        ProductAttributeQueryBuilderInterface $queryBuilder,
        ProductAttributeValueFactoryInterface $productAttributeValueFactory
    ) {
        $this->beConstructedWith($connection, $queryBuilder, $productAttributeValueFactory);
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Repository\Doctrine\ProductAttributeRepository');
    }
}
