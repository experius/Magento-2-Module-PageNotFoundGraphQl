<?php
/**
 * Copyright © Experius B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Experius\PageNotFoundGraphQl\Plugin\Graphql\Magento\UrlRewriteGraphQl\Model\Resolver;

use Magento\Store\Api\Data\StoreInterface;

class Route
{
    /**
     * @var \Experius\PageNotFound\Model\PageNotFoundFactory
     */
    private $pageNotFoundFactory;

    /**
     * EntityUrl constructor.
     *
     * @param \Experius\PageNotFound\Model\PageNotFoundFactory $pageNotFoundFactory
     */
    public function __construct(
        \Experius\PageNotFound\Model\PageNotFoundFactory $pageNotFoundFactory
    ) {
        $this->pageNotFoundFactory = $pageNotFoundFactory;
    }

    /**
     * @param \Magento\UrlRewriteGraphQl\Model\Resolver\EntityUrl $subject
     * @param $result
     * @param $field
     * @param $context
     * @param $info
     * @param array|null $value
     * @param array|null $args
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundResolve(
        \Magento\UrlRewriteGraphQl\Model\Resolver\Route $subject,
        $proceed,
        $field,
        $context,
        $info,
        array $value = null,
        array $args = null
    ) {
        $result = $proceed($field, $context, $info, $value, $args);
        if (is_null($result) && $args['url'] != '/') {
            $args['url'] = $this->savePageNotFound($args['url'], $context->getExtensionAttributes()->getStore()) ?: $args['url'];
            $result = $proceed($field, $context, $info, $value, $args);
            if (!is_null($result)) {
                $result['redirect_code'] = 301;
            }
        }
        return $result;
    }

    /**
     * @param $fromUrl
     * @param StoreInterface $store
     * @return string|null
     * @throws \Exception
     */
    protected function savePageNotFound(
        $fromUrl,
        StoreInterface $store
    ) {
        /* @var $pageNotFoundModel \Experius\PageNotFound\Model\PageNotFound */
        $pageNotFoundModel = $this->pageNotFoundFactory->create();
        $baseUrl = $store->getBaseUrl();
        if (strpos($fromUrl, $baseUrl) === false) {
            $fromUrl = $baseUrl . ltrim($fromUrl, '/');
        }
        $pageNotFoundModel->load($fromUrl,'from_url');

        if($pageNotFoundModel->getId()){
            $count = $pageNotFoundModel->getCount();
            $pageNotFoundModel->setCount($count+1);
        } else {
            $pageNotFoundModel->setFromUrl($fromUrl);
            $pageNotFoundModel->setCount(1);
        }

        if($pageNotFoundModel->getToUrl()) {
            $pageNotFoundModel->setCountRedirect($pageNotFoundModel->getCountRedirect()+1);
        }

        $pageNotFoundModel->save();
        if($pageNotFoundModel->getToUrl()) {
            return str_replace($baseUrl, '', $pageNotFoundModel->getToUrl());
        }
        return null;
    }
}

