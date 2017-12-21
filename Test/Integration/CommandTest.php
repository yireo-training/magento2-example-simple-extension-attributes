<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Test\Integration;

use Magento\Framework\Console\CommandList;
use Symfony\Component\Console\Tester\CommandTester;
use Yireo\ExampleSimpleExtensionAttributes\Command\Test;

class CommandTest extends Common
{
    public function testIfCommandIsThere()
    {
        $targetCommand = $this->createObject(Test::class);
        $commandTester = new CommandTester($targetCommand);

        $commandTester->execute([]);
        $this->assertSame(trim($commandTester->getDisplay()), 'Hello World');
    }
}
