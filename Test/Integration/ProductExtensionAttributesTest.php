<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Test\Integration;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product as ProductModel;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;

use TddWizard\Fixtures\Catalog\ProductBuilder;
use TddWizard\Fixtures\Catalog\ProductFixture;
use TddWizard\Fixtures\Catalog\ProductFixtureRollback;

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
     */
    public function testSaveAndLoadExtensionAttribute()
    {
        $productRepository = $this->getProductRepository();
        $product = $productRepository->get('sample01');

        $date = date('Y-m-d');
        $product->setTrainingDateStart($date);
        $productRepository->save($product);

        /** @var ProductModel $product */
        $newProduct = $productRepository->get('sample01');
        $this->assertSame($newProduct->getTrainingDateStart(), $product->getTrainingDateStart());
    }

    /**
     * Setup method
     */
    protected function setUp()
    {
        parent::setUp();
        $this->productFixture = new ProductFixture(
            ProductBuilder::aSimpleProduct()
                ->withSku('sample01')
                ->withPrice(10)
                ->build()
        );
    }

    /**
     * Tear down method
     */
    protected function tearDown()
    {
        ProductFixtureRollback::create()->execute($this->productFixture);
    }

    /**
     * @param int $productId
     *
     * @return ProductModel
     */
    private function getProductModel(int $productId = 1) : ProductModel
    {
        $product = $this->createObject(ProductModel::class);
        $productResource = $this->getProductResource();
        $productResource->load($product, $productId);

        return $product;
    }

    /**
     * @return ProductResource
     */
    private function getProductResource() : ProductResource
    {
        return $this->createObject(ProductResource::class);
    }

    private function getProductRepository() : ProductRepositoryInterface
    {
        /** @var ProductRepositoryInterface $productRepository */
        $productRepository = $this->createObject(ProductRepositoryInterface::class);
        return $productRepository;
    }
}
