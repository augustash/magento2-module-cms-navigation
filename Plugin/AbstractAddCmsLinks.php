<?php

/**
 * CMS Navigation Module
 *
 * Adds CMS pages and custom links to category navigation.
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2019 August Ash (https://www.augustash.com)
 */

namespace Augustash\CmsNavigation\Plugin;

use Augustash\CmsNavigation\Api\ConfigInterface;
use Augustash\CmsNavigation\Api\LinkManagementInterface;
use Magento\Theme\Block\Html\Topmenu as Subject;

/**
 * Abstract CMS pages class.
 */
abstract class AbstractAddCmsLinks
{
    /**
     * @var \Augustash\CmsNavigation\Api\ConfigInterface
     */
    protected $config;

    /**
     * @var \Augustash\CmsNavigation\Api\LinkManagementInterface
     */
    protected $linkManagement;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\CmsNavigation\Api\ConfigInterface $config
     * @param \Augustash\CmsNavigation\Api\LinkManagementInterface $linkManagement
     */
    public function __construct(
        ConfigInterface $config,
        LinkManagementInterface $linkManagement
    ) {
        $this->config = $config;
        $this->linkManagement = $linkManagement;
    }

    /**
     * Add configured CMS links to top menu navigation.
     *
     * @param \Magento\Theme\Block\Html\Topmenu $menu
     * @return void
     */
    abstract public function addLinks(Subject $menu);

    /**
     * Get top menu html
     *
     * @param \Magento\Theme\Block\Html\Topmenu $subject
     * @param string $outermostClass
     * @param string $childrenWrapClass
     * @param int $limit
     * @return string|null
     */
    public function beforeGetHtml(Subject $subject, $outermostClass = '', $childrenWrapClass = '', $limit = 0)
    {
        if (!$this->config->isEnabled()) {
            return null;
        }

        $this->addLinks($subject);

        return [
            $outermostClass,
            $childrenWrapClass,
            $limit,
        ];
    }
}
