<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Yireo\ExampleSimpleExtensionAttributes\Model\ExampleAttributes;
use Yireo\ExampleSimpleExtensionAttributes\Model\ResourceModel\ExampleAttributes as ResourceModel;
use Yireo\ExampleSimpleExtensionAttributes\Model\ExampleAttributes as RegularModel;

/**
 * Class ProcessExampleAttributes
 *
 * @package Yireo\ExampleSimpleExtensionAttributes\Plugin
 */
class ProcessExampleAttributes
{
    /**
     * @var ResourceModel
     */
    private $resourceModel;

    /**
     * @var RegularModel
     */
    private $model;

    /**
     * ProcessExampleAttributes constructor.
     *
     * @param RegularModel $model
     * @param ResourceModel $resourceModel
     */
    public function __construct(
        RegularModel $model,
        ResourceModel $resourceModel
    )
    {
        $this->resourceModel = $resourceModel;
        $this->model = $model;
    }

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param ProductInterface $product
     *
     * @return ProductInterface
     */
    public function afterGet(ProductRepositoryInterface $productRepository, ProductInterface $product)
    {
        $exampleAttributesModel = $this->getExampleAttributesByProduct($product);
        if ($exampleAttributesModel === null) {
            return $product;
        }

        $product->getExtensionAttributes()->setTrainingDateStart($exampleAttributesModel->getTrainingDateStart());
        $product->getExtensionAttributes()->setTrainingDateEnd($exampleAttributesModel->getTrainingDateEnd());
        return $product;
    }

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param ProductInterface $product
     *
     * @return ProductInterface
     */
    public function afterGetById(ProductRepositoryInterface $productRepository, ProductInterface $product)
    {
        $exampleAttributesModel = $this->getExampleAttributesByProduct($product);
        if ($exampleAttributesModel === null) {
            return $product;
        }

        $product->getExtensionAttributes()->setTrainingDateStart($exampleAttributesModel->getTrainingDateStart());
        $product->getExtensionAttributes()->setTrainingDateEnd($exampleAttributesModel->getTrainingDateEnd());
        return $product;
    }

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param ProductInterface $product
     * @param bool $saveOptions
     *
     * @return array
     */
    public function beforeSave(ProductRepositoryInterface $productRepository, ProductInterface $product, $saveOptions = false)
    {
        $exampleAttributesModel = $this->getExampleAttributesByProduct($product);
        if (!$exampleAttributesModel) {
            $exampleAttributesModel = $this->model;
        }

        $extensionAttributes = $product->getExtensionAttributes();
        if ($extensionAttributes === null) {
            return [$product, $saveOptions];
        }

        $exampleAttributesModel->setProductId((int)$product->getId());
        $exampleAttributesModel->setTrainingDateStart($product->getExtensionAttributes()->getTrainingDateStart());
        $exampleAttributesModel->setTrainingDateEnd($product->getExtensionAttributes()->getTrainingDateEnd());

        $this->resourceModel->save($exampleAttributesModel);

        return [$product, $saveOptions];
    }

    /**
     * @param ProductInterface $product
     *
     * @return RegularModel
     */
    private function getExampleAttributesByProduct(ProductInterface $product) : ExampleAttributes
    {
        $collection = $this->model->getCollection();
        $collection->addFieldToFilter('product_id', $product->getId());

        /** @var ExampleAttributes $firstItem */
        $firstItem = $collection->getFirstItem();
        return $firstItem;
    }
}