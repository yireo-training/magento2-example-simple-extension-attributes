<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\AlreadyExistsException;

use Yireo\ExampleSimpleExtensionAttributes\Model\ExampleAttributes;
use Yireo\ExampleSimpleExtensionAttributes\Model\ResourceModel\ExampleAttributes as ResourceModel;
use Yireo\ExampleSimpleExtensionAttributes\Model\ExampleAttributesFactory as ModelFactory;
use Yireo\ExampleSimpleExtensionAttributes\Model\ExampleAttributes as Model;
use Yireo\ExampleSimpleExtensionAttributes\Model\ResourceModel\ExampleAttributes\CollectionFactory;

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
     * @var ModelFactory
     */
    private $modelFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * ProcessExampleAttributes constructor.
     *
     * @param ModelFactory $modelFactory
     * @param ResourceModel $resourceModel
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        ModelFactory $modelFactory,
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
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
     * @throws AlreadyExistsException
     */
    public function beforeSave(ProductRepositoryInterface $productRepository, ProductInterface $product, $saveOptions = false)
    {
        $exampleAttributesModel = $this->getExampleAttributesByProduct($product);
        if (!$exampleAttributesModel) {
            $exampleAttributesModel = $this->modelFactory->create();
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
     * @return Model
     */
    private function getExampleAttributesByProduct(ProductInterface $product): ExampleAttributes
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('product_id', $product->getId());

        /** @var ExampleAttributes $firstItem */
        $firstItem = $collection->getFirstItem();

        return $firstItem;
    }
}