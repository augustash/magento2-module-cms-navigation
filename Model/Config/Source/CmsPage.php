<?php

/**
 * CMS Navigation Module
 *
 * Adds CMS pages and custom links to category navigation.
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2019 August Ash (https://www.augustash.com)
 */

namespace Augustash\CmsNavigation\Model\Config\Source;

use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Store\Model\StoreManager;

/**
 * CMS page config source class.
 * @api
 */
class CmsPage implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $storeManager;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Store\Model\StoreManager $storeManager
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        StoreManager $storeManager
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->request = $request;
        $this->storeManager = $storeManager;
    }

    /**
     * Options getter.
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $websiteId = $this->request->getParam('website', 0);
            $storeId = $this->request->getParam('store', 0);

            /** @var \Magento\Cms\Model\ResourceModel\Page\Collection $collection */
            $collection = $this->collectionFactory
                ->create()
                ->addFieldToFilter('is_active', ['eq' => 1])
                ->addOrder('title', 'ASC');

            if ($websiteId != 0) {
                $stores = $this->storeManager->getStoreByWebsiteId($websiteId);
                $storeId = \array_shift($stores);
                $store = $this->storeManager->getStore($storeId);
                $collection->addStoreFilter($store);
            } elseif ($storeId != 0) {
                $store = $this->storeManager->getStore($storeId);
                $collection->addStoreFilter($store);
            }

            $this->options[] = [
                'label' => '- None -',
                'value' => null,
            ];

            $pages = $collection->getItems();
            foreach ($pages as $page) {
                /** @var \Magento\Cms\Model\Page $page */
                $this->options[] = [
                    'label' => $page->getTitle(),
                    'value' => $page->getId(),
                ];
            }
        }

        return $this->options;
    }

    /**
     * Get options in "key-value" format.
     *
     * @return array
     */
    public function toArray()
    {
        $result = [];
        $options = $this->toOptionArray();

        foreach ($options as $option) {
            $result[$option['value']] = $option['label'];
        }

        return $result;
    }
}
