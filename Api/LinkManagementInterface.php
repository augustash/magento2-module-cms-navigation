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

use Magento\Theme\Block\Html\Topmenu;

/**
 * Service interface responsible for add CMS navigation links.
 * @api
 */
interface LinkManagementInterface
{
    /**
     * Adds configured links to the top menu.
     *
     * @param \Magento\Theme\Block\Html\Topmenu $menu
     * @param string $position
     * @return void
     */
    public function addLinks(Topmenu $menu, $position = 'right');
}
