<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface TrainingDetailsInterface extends ExtensibleDataInterface
{
    public function getTrainingDateStart() : string;

    public function setTrainingDateStart(string $trainingDateStart);

    public function getTrainingDateEnd() : string;

    public function setTrainingDateEnd(string $trainingDateEnd);
}