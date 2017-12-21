<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Model\ResourceModel\ExampleAttributes;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Yireo\ExampleSimpleExtensionAttributes\Model\ResourceModel\ExampleAttributes as ResourceModel;
use Yireo\ExampleSimpleExtensionAttributes\Model\ExampleAttributes as RegularModel;

/**
 * Class Collection
 *
 * @package Yireo\ExampleSimpleExtensionAttributes\Model\ResourceModel\ExampleAttributes
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init(RegularModel::class, ResourceModel::class);
    }
}