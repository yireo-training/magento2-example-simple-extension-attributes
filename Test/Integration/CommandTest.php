<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Test\Integration;

use Symfony\Component\Console\Tester\CommandTester;
use Yireo\ExampleSimpleExtensionAttributes\Command\Test;

class CommandTest extends Common
{
    /**
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     */
    public function testIfCommandIsThere()
    {
        $targetCommand = $this->createObject(Test::class);
        $commandTester = new CommandTester($targetCommand);

        $commandTester->execute([]);
        $this->assertNotEmpty(trim($commandTester->getDisplay()));
    }
}
