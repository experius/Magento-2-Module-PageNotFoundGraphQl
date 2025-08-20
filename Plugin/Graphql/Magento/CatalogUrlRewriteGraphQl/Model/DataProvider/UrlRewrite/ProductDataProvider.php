<?php
declare(strict_types=1);

namespace Experius\PageNotFoundGraphQl\Plugin\Graphql\Magento\CatalogUrlRewriteGraphQl\Model\DataProvider\UrlRewrite;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class ProductDataProvider
{

    public function __construct(
        protected ProductRepository $productRepository
    )
    {
    }

    /**
     * @param \Magento\CatalogUrlRewriteGraphQl\Model\DataProvider\UrlRewrite\ProductDataProvider $subject
     * @param \Closure $proceed
     * @param string $entity_type
     * @param int $id
     * @param ResolveInfo|null $info
     * @param int|null $storeId
     * @return mixed
     * @throws NoSuchEntityException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundGetData(
        \Magento\CatalogUrlRewriteGraphQl\Model\DataProvider\UrlRewrite\ProductDataProvider $subject,
        \Closure                                                                            $proceed,
        string                                                                              $entity_type,
        int                                                                                 $id,
        ?ResolveInfo                                                                        $info = null,
        ?int                                                                                $storeId = null
    )
    {
        $product = $this->productRepository->getById($id, false, $storeId);
        $result = $product->getData();

        $result['model'] = $product;
        return $result;
    }
}
