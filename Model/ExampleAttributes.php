<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Model;

use Magento\Framework\Model\AbstractModel;
use Yireo\ExampleSimpleExtensionAttributes\Model\ResourceModel\ExampleAttributes as ResourceModel;

/**
 * Class ExampleAttributes
 *
 * @package Yireo\ExampleSimpleExtensionAttributes\Model\ResourceModel
 */
class ExampleAttributes extends AbstractModel
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int
     */
    public function getProductId() : int
    {
        return (int)$this->getData('product_id');
    }

    /**
     * @param int $productId
     *
     * @return $this
     */
    public function setProductId(int $productId)
    {
        return $this->setData('product_id', $productId);
    }

    /**
     * @return string
     */
    public function getTrainingDateStart() : string
    {
        return (string)$this->getData('training_date_start');
    }

    /**
     * @param string $trainingDateStart
     *
     * @return $this
     */
    public function setTrainingDateStart(string $trainingDateStart)
    {
        return $this->setData('training_date_start', $trainingDateStart);
    }

    /**
     * @return string
     */
    public function getTrainingDateEnd() : string
    {
        return (string)$this->getData('training_date_end');
    }

    /**
     * @param string $trainingDateEnd
     *
     * @return $this
     */
    public function setTrainingDateEnd(string $trainingDateEnd)
    {
        return $this->setData('training_date_end', $trainingDateEnd);
    }
}