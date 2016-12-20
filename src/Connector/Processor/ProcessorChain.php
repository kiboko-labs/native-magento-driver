<?php

namespace Kiboko\Component\Connector\Processor;

use Akeneo\Component\Batch\Item\FlushableInterface;
use Akeneo\Component\Batch\Item\InitializableInterface;
use Akeneo\Component\Batch\Item\ItemProcessorInterface;
use Akeneo\Component\Batch\Model\StepExecution;
use Akeneo\Component\Batch\Step\StepExecutionAwareInterface;

class ProcessorChain implements
    ItemProcessorInterface,
    InitializableInterface,
    FlushableInterface,
    StepExecutionAwareInterface
{
    /**
     * @var ItemProcessorInterface[]
     */
    private $processors;

    /**
     * @var InitializableInterface[]
     */
    private $initializableProcessors;

    /**
     * @var FlushableInterface[]
     */
    private $flushableProcessors;

    /**
     * @var StepExecution
     */
    private $stepExecution;

    /**
     * ProcessorStack constructor.
     *
     * @param ItemProcessorInterface[] $processors
     */
    public function __construct(array $processors)
    {
        $this->processors = new \SplObjectStorage();
        $this->initializableProcessors = new \SplObjectStorage();
        $this->flushableProcessors = new \SplObjectStorage();

        $this->attachAll($processors);
    }

    /**
     * @param ItemProcessorInterface $processor
     */
    public function attach(ItemProcessorInterface $processor)
    {
        $this->processors->attach($processor);

        if ($processor instanceof InitializableInterface) {
            $this->initializableProcessors->attach($processor);
        }

        if ($processor instanceof FlushableInterface) {
            $this->flushableProcessors->attach($processor);
        }
    }

    /**
     * @param ItemProcessorInterface[] $processors
     */
    public function attachAll(array $processors)
    {
        foreach ($processors as $processor) {
            $this->attach($processor);
        }
    }

    /**
     * @param ItemProcessorInterface $processor
     */
    public function detach(ItemProcessorInterface $processor)
    {
        $this->processors->detach($processor);

        if ($processor instanceof InitializableInterface) {
            $this->initializableProcessors->detach($processor);
        }

        if ($processor instanceof FlushableInterface) {
            $this->flushableProcessors->detach($processor);
        }
    }

    /**
     * @param ItemProcessorInterface[] $processors
     */
    public function detachAll(array $processors)
    {
        foreach ($processors as $processor) {
            $this->detach($processor);
        }
    }

    public function flush()
    {
        foreach ($this->flushableProcessors as $processor) {
            $processor->flush();
        }
    }

    public function initialize()
    {
        foreach ($this->initializableProcessors as $processor) {
            $processor->initialize();
        }
    }

    public function process($item)
    {
        foreach ($this->processors as $processor) {
            $item = $processor->process($item);
            if ($item === null) {
                return null;
            }
        }
    }

    /**
     * @param StepExecution $stepExecution
     */
    public function setStepExecution(StepExecution $stepExecution)
    {
        $this->stepExecution = $stepExecution;
    }
}
