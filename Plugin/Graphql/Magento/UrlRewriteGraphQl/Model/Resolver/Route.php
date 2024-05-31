<?php
/**
 * Copyright © Experius B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Experius\PageNotFoundGraphQl\Plugin\Graphql\Magento\UrlRewriteGraphQl\Model\Resolver;

use Experius\PageNotFound\Observer\Controller\ActionPredispatch;
use Magento\UrlRewriteGraphQl\Model\Resolver\EntityUrl;
use Magento\UrlRewriteGraphQl\Model\Resolver\Route as MagentoRoute;

class Route extends ActionPredispatch
{
    /**
     * @param EntityUrl $subject
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
        MagentoRoute $subject,
              $proceed,
              $field,
              $context,
              $info,
        array $value = null,
        array $args = null
    )
    {
        $result = $proceed($field, $context, $info, $value, $args);
        if (is_null($result) && $args['url'] != '/') {
            $args['url'] = $this->savePageNotFound($args['url'], true, $context->getExtensionAttributes()->getStore()) ?: $args['url'];
            $result = $proceed($field, $context, $info, $value, $args);
            if (!is_null($result)) {
                $result['redirect_code'] = 301;
            }
        }
        return $result;
    }

}
