<?php

/**
 * CMS Navigation Module
 *
 * Adds CMS pages and custom links to category navigation.
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2019 August Ash (https://www.augustash.com)
 */

namespace Augustash\CmsNavigation\Model;

use Augustash\CmsNavigation\Api\ConfigInterface;
use Magento\Cms\Helper\Page;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Configuration class.
 */
class Config implements ConfigInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(
        $scope = ScopeInterface::SCOPE_STORE,
        $scopeCode = null
    ): bool {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_CMSNAV_ENABLED,
            $scope,
            $scopeCode
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getHomeIdentifier(
        $scope = ScopeInterface::SCOPE_STORE,
        $scopeCode = null
    ): string {
        return $this->scopeConfig->getValue(
            Page::XML_PATH_HOME_PAGE,
            $scope,
            $scopeCode
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuItemsLeft(
        $scope = ScopeInterface::SCOPE_STORE,
        $scopeCode = null
    ): array {
        $items = $this->scopeConfig->getValue(
            self::XML_PATH_CMSNAV_MENU_LEFT,
            $scope,
            $scopeCode
        );

        return \explode(',', $items);
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuItemsRight(
        $scope = ScopeInterface::SCOPE_STORE,
        $scopeCode = null
    ): array {
        $items = $this->scopeConfig->getValue(
            self::XML_PATH_CMSNAV_MENU_RIGHT,
            $scope,
            $scopeCode
        );

        return \explode(',', $items);
    }
}
