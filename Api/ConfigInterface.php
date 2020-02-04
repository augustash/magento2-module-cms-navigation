<?php

/**
 * CMS Navigation Module
 *
 * Adds CMS pages and custom links to category navigation.
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2019 August Ash (https://www.augustash.com)
 */

namespace Augustash\CmsNavigation\Api;

use Magento\Store\Model\ScopeInterface;

/**
 * Service interface responsible for exposing configuration options.
 * @api
 */
interface ConfigInterface
{
    /**
     * Configuration constants.
     */
    const XML_PATH_CMSNAV_ENABLED = 'cms/cms_navigation/enabled';
    const XML_PATH_CMSNAV_MENU_LEFT = 'cms/cms_navigation/side_left';
    const XML_PATH_CMSNAV_MENU_RIGHT = 'cms/cms_navigation/side_right';

    /**
     * Returns the module's enabled status.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return bool
     */
    public function isEnabled(
        $scope = ScopeInterface::SCOPE_STORE,
        $scopeCode = null
    ): bool;

    /**
     * Returns the store's home page identifier.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return string
     */
    public function getHomeIdentifier(
        $scope = ScopeInterface::SCOPE_STORE,
        $scopeCode = null
    ): string;

    /**
     * Returns the module's left-side menu items.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return array
     */
    public function getMenuItemsLeft(
        $scope = ScopeInterface::SCOPE_STORE,
        $scopeCode = null
    ): array;

    /**
     * Returns the module's right-side menu items.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return array
     */
    public function getMenuItemsRight(
        $scope = ScopeInterface::SCOPE_STORE,
        $scopeCode = null
    ): array;
}
