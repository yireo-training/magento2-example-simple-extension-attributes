<?php
declare(strict_types=1);

namespace Yireo\ExampleSimpleExtensionAttributes\Command;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\State;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Test
 *
 * @package Yireo\ExampleSimpleExtensionAttributes\Command
 */
class Test extends Command
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var State
     */
    private $appState;

    /**
     * Test constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param State $appState
     * @param null $name
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        State $appState,
        $name = null
    ) {
        parent::__construct($name);
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->appState = $appState;
    }

    /**
     * Configure this command
     */
    protected function configure()
    {
        $this->setName('example_simple_extension_attributes:test');
        $this->setDescription('Test whether example extension attributes are working.');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Load and save a product
        $product = $this->loadSomeProduct();
        $this->setTrainingDates($product);
        $this->saveProduct($product);

        // Load the same product twice but now from the database
        $newProduct = $this->productRepository->get($product->getSku());

        // Compare the result
        $output->writeln((string)$product->getExtensionAttributes()->getTrainingDateStart() . ' = ' . (string)$newProduct->getExtensionAttributes()->getTrainingDateStart());
    }

    /**
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    private function loadSomeProduct() : ProductInterface
    {
        $productSku = $this->getFirstProductSkuFromCatalog();
        $product = $this->productRepository->get($productSku);
        return $product;
    }

    /**
     * @param ProductInterface $product
     *
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws LocalizedException
     * @throws StateException
     */
    private function saveProduct(ProductInterface $product)
    {
        $this->appState->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
        $this->productRepository->save($product);
    }

    /**
     * @param ProductInterface $product
     */
    private function setTrainingDates(ProductInterface &$product)
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime('tomorrow'));
        $product->getExtensionAttributes()->setTrainingDateStart($startDate);
        $product->getExtensionAttributes()->setTrainingDateEnd($endDate);
    }

    /**
     * @return string
     */
    private function getFirstProductSkuFromCatalog(): string
    {
        $this->searchCriteriaBuilder->setPageSize(1);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResult = $this->productRepository->getList($searchCriteria);
        $products = $searchResult->getItems();
        $product = array_pop($products);

        return $product->getSku();
    }
}