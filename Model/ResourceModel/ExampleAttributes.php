<?php
namespace Yireo\ExampleSimpleExtensionAttributes\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class ExampleAttributes
 *
 * @package Yireo\ExampleSimpleExtensionAttributes\Model\ResourceModel
 */
class ExampleAttributes extends AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('example_extension_attributes', 'id');
    }
}