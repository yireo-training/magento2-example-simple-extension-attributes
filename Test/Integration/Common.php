<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Test\Integration;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\ObjectManager;
use PHPUnit\Framework\TestCase;

/**
 * Class Common
 *
 * @package Yireo\ExampleSimpleExtensionAttributes\Test\Integration
 */
class Common extends TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * Setup method
     */
    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
    }

    /**
     * @param string $className
     *
     * @return object
     */
    protected function createObject(string $className)
    {
        return $this->objectManager->create($className);
    }
}
