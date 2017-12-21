<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Attribute\Product;

use Magento\Framework\Model\AbstractExtensibleModel;
use Yireo\ExampleSimpleExtensionAttributes\Api\Data\TrainingDetailsInterface;

/**
 * Class TrainingDateEnd
 *
 * @package Yireo\ExampleSimpleExtensionAttributes\Model\Product
 */
class TrainingDetails extends AbstractExtensibleModel implements TrainingDetailsInterface
{
    /**
     * @var string
     */
    private $trainingDateStart;

    /**
     * @var string
     */
    private $trainingDateEnd;

    /**
     * @return string
     */
    public function getTrainingDateStart(): string
    {
        return $this->trainingDateStart;
    }

    /**
     * @param string $trainingDateStart
     */
    public function setTrainingDateStart(string $trainingDateStart)
    {
        $this->trainingDateStart = $trainingDateStart;
    }

    /**
     * @return string
     */
    public function getTrainingDateEnd(): string
    {
        return $this->trainingDateEnd;
    }

    /**
     * @param string $trainingDateEnd
     */
    public function setTrainingDateEnd(string $trainingDateEnd)
    {
        $this->trainingDateEnd = $trainingDateEnd;
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Magento\Framework\Api\ExtensionAttributesInterface
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     *
     * @param TrainingDetailsInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        TrainingDetailsInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}