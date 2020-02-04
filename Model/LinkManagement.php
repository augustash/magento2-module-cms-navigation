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
use Augustash\CmsNavigation\Api\LinkManagementInterface;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\UrlInterface;
use Magento\Theme\Block\Html\Topmenu;

/**
 * Top menu link management class.
 */
class LinkManagement implements LinkManagementInterface
{
    /**
     * @var string
     */
    protected $homeIdentifier;

    /**
     * @var \Augustash\CmsNavigation\Api\ConfigInterface
     */
    protected $config;

    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var \Magento\Framework\Data\Tree\NodeFactory
     */
    protected $nodeFactory;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\CmsNavigation\Api\ConfigInterface $config
     * @param \Magento\Cms\Api\PageRepositoryInterface $pageRepository
     * @param \Magento\Framework\Data\Tree\NodeFactory $nodeFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     */
    public function __construct(
        ConfigInterface $config,
        PageRepositoryInterface $pageRepository,
        NodeFactory $nodeFactory,
        UrlInterface $urlBuilder
    ) {
        $this->config = $config;
        $this->pageRepository = $pageRepository;
        $this->nodeFactory = $nodeFactory;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function addLinks(Topmenu $menu, $position = 'right')
    {
        switch ($position) {
            case 'left':
                $menuItems = $this->config->getMenuItemsLeft();
                break;
            case 'right':
                $menuItems = $this->config->getMenuItemsRight();
                break;
        }

        if (!$menuItems || empty($menuItems)) {
            return;
        }

        foreach ($menuItems as $menuItem) {
            // skip null or empty items
            if (!$menuItem) {
                continue;
            }

            $menu->getMenu()->addChild(
                $this->createTopMenuNode($menu, $menuItem, $position)
            );
        }
    }

    protected function createTopMenuNode($menu, $menuItem, $position)
    {
        $page = $this->pageRepository->getById($menuItem);

        return $this->nodeFactory->create(
            [
                'data' => [
                    'name' => $page->getTitle(),
                    'id' => 'cms-page-' . $position . '-' . $page->getIdentifier(),
                    'url' => $this->getCmsPageUrl($page),
                    'has_active' => false,
                    'is_active' => false
                ],
                'idField' => 'id',
                'tree' => $menu->getMenu()->getTree()
            ]
        );
    }

    /**
     * Build the URL for the specified CMS page.
     *
     * @param \Magento\Cms\Api\Data\PageInterface $page
     * @return string
     */
    protected function getCmsPageUrl(PageInterface $page): string
    {
        if ($page->getIdentifier() == $this->getHomePageIdentifier()) {
            return $this->urlBuilder->getUrl();
        }

        return $this->urlBuilder->getUrl(null, ['_direct' => $page->getIdentifier()]);
    }

    /**
     * Get the store's configured home page identifier.
     *
     * @return string
     */
    protected function getHomePageIdentifier(): string
    {
        if (!$this->homeIdentifier) {
            $this->homeIdentifier = $this->config->getHomeIdentifier();
        }

        return $this->homeIdentifier;
    }
}
