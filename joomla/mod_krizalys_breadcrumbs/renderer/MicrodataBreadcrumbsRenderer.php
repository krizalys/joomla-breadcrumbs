<?php
/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2015 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    GNU General Public License version 3 (http://www.gnu.org/licenses/gpl.html).
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

require_once __DIR__ . '/BaseBreadcrumbsRenderer.php';

class MicrodataBreadcrumbsRenderer extends BaseBreadcrumbsRenderer
{
    private function makeItemScope()
    {
        $itemscope = 'itemscope';

        if ($this->isUseXhtml()) {
            $itemscope .= '="itemscope"';
        }

        return $itemscope;
    }

    protected function getContainerAttrs()
    {
        return $this->makeItemScope()
            . ' itemtype="http://schema.org/BreadcrumbList"';
    }

    protected function getItemContainerAttrs()
    {
        return $this->makeItemScope() . ' itemprop="itemListElement"'
            . ' itemtype="http://schema.org/ListItem"';
    }

    protected function getItemAttrs()
    {
        return 'itemprop="item"';
    }

    protected function getNameAttrs()
    {
        return 'itemprop="name"';
    }
}
