<?php

namespace spec\Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Factory\FamilyFactoryInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\FamilyQueryBuilderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FamilyRepositorySpec extends ObjectBehavior
{
    function it_is_initializable(
        Connection $connection,
        FamilyQueryBuilderInterface $queryBuilder,
        FamilyFactoryInterface $familyFactory
    ) {
        $this->beConstructedWith($connection, $queryBuilder, $familyFactory);
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Repository\Doctrine\FamilyRepository');
    }
}
