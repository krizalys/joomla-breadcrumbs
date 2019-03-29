<?php

/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2019 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    GNU General Public License version 3 (http://www.gnu.org/licenses/gpl.html).
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

require_once __DIR__ . '/BaseBreadcrumbsRenderer.php';

class MicrodataBreadcrumbsRenderer extends BaseBreadcrumbsRenderer
{
    /**
     * @return string
     */
    private function makeItemScope()
    {
        $itemscope = 'itemscope';

        if ($this->isUseXhtml()) {
            $itemscope .= '="itemscope"';
        }

        return $itemscope;
    }

    /**
     * @return string
     */
    protected function getContainerAttrs()
    {
        return $this->makeItemScope()
            . ' itemtype="http://schema.org/BreadcrumbList"';
    }

    /**
     * @return string
     */
    protected function getItemContainerAttrs()
    {
        return $this->makeItemScope() . ' itemprop="itemListElement"'
            . ' itemtype="http://schema.org/ListItem"';
    }

    /**
     * @return string
     */
    protected function getItemAttrs()
    {
        return 'itemprop="item"';
    }

    /**
     * @return string
     */
    protected function getNameAttrs()
    {
        return 'itemprop="name"';
    }
}
