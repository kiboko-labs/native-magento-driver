<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Model\AttributeLabelInterface;

interface AttributeLabelPersisterInterface
{
    public function initialize();

    /**
     * @param AttributeLabelInterface $attributeLabel
     */
    public function persist(AttributeLabelInterface $attributeLabel);

    /**
     * @param AttributeLabelInterface $attributeLabel
     */
    public function __invoke(AttributeLabelInterface $attributeLabel);

    public function flush();
}
