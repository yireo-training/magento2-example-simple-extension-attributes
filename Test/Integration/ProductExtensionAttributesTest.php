<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Test\Integration;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product as ProductModel;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use TddWizard\Fixtures\Catalog\ProductFixture;

class ProductExtensionAttributesTest extends Common
{
    /**
     * @var ProductFixture
     */
    protected $productFixture;

    /**
     * Test whether the custom attributes are part of the extension attributes interface
     */
    public function testCurrentProductExtensionAttributes()
    {
        /** @var ProductInterface $product */
        $product = $this->createObject(ProductInterface::class);
        $extensionAttributes = $product->getExtensionAttributes();
        $this->assertContains('getTrainingDateStart', get_class_methods($extensionAttributes));
        $this->assertContains('getTrainingDateEnd', get_class_methods($extensionAttributes));
    }

    /**
     * Try to save and load the custom extension attributes
     *
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     *
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function testSaveAndLoadExtensionAttribute()
    {
        $productRepository = $this->getProductRepository();
        $product = $productRepository->get('simple');

        $date = date('Y-m-d');
        $product->getExtensionAttributes()->setTrainingDateStart($date);
        $productRepository->save($product);

        /** @var ProductModel $product */
        $newProduct = $productRepository->get('simple');

        $this->assertSame($newProduct->getExtensionAttributes()->getTrainingDateStart(), $product->getExtensionAttributes()->getTrainingDateStart());
    }

    /**
     * @return ProductRepositoryInterface
     */
    private function getProductRepository() : ProductRepositoryInterface
    {
        /** @var ProductRepositoryInterface $productRepository */
        $productRepository = $this->createObject(ProductRepositoryInterface::class);
        return $productRepository;
    }
}
