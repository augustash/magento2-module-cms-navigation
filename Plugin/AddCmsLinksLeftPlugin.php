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

use Magento\Theme\Block\Html\Topmenu as Subject;

/**
 * Add CMS pages to top menu left side.
 */
class AddCmsLinksLeftPlugin extends AbstractAddCmsLinks
{
    /**
     * {@inheritdoc}
     */
    public function addLinks(Subject $menu)
    {
        $this->linkManagement->addLinks($menu, 'left');
    }
}
