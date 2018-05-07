<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{

    /**
     * @param SchemaSetupInterface $installer
     * @param ModuleContextInterface $context
     *
     * @return void
     */
    public function uninstall(SchemaSetupInterface $installer, ModuleContextInterface $context)
    {
        $installer->startSetup();
        $connection = $installer->getConnection();
        $connection->dropTable($connection->getTableName('example_simple_extension_attributes'));
        $installer->endSetup();
    }
}