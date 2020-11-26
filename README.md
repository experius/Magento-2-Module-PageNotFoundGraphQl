# Mage2 Module Experius PageNotFoundGraphQl

    ``experius/module-pagenotfoundgraphql``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities

Return a redirect in the GraphQl urlResolver based on the Experius_PageNotFound module.

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Experius`
 - Enable the module by running `php bin/magento module:enable Experius_PageNotFoundGraphQl`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require experius/module-pagenotfoundgraphql`
 - enable the module by running `php bin/magento module:enable Experius_PageNotFoundGraphQl`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`



## Specifications

 - UrlRewriteEntityTypeEnum
    - PAGE_NOT_FOUND_REDIRECT
 - Plugin
	- afterResolve - Magento\UrlRewriteGraphQl\Model\Resolver\EntityUrl > Experius\PageNotFoundGraphQl\Plugin\Graphql\Magento\UrlRewriteGraphQl\Model\Resolver\EntityUrl




