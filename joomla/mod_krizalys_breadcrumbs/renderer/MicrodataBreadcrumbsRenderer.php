<?php

/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2021 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    3-Clause BSD License (https://opensource.org/licenses/BSD-3-Clause).
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
     * @param int $index
     *
     * @return string
     */
    protected function getMetaTag($index)
    {
        $tag = '<meta itemprop="position" content="' . $index . '"';

        if ($this->isUseXhtml()) {
            $tag .= ' /';
        }

        $tag .= '>';
        return $tag;
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
