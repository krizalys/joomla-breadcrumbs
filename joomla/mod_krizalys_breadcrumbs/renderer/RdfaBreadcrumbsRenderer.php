<?php

/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2020 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    3-Clause BSD License (https://opensource.org/licenses/BSD-3-Clause).
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

require_once __DIR__ . '/BaseBreadcrumbsRenderer.php';

class RdfaBreadcrumbsRenderer extends BaseBreadcrumbsRenderer
{
    /**
     * @param int $index
     *
     * @return string
     */
    protected function getMetaTag($index)
    {
        $tag = '<meta property="position" content="' . $index . '"';

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
        return 'vocab="http://schema.org/" typeof="BreadcrumbList"';
    }

    /**
     * @return string
     */
    protected function getItemContainerAttrs()
    {
        return 'property="itemListElement" typeof="ListItem"';
    }

    /**
     * @return string
     */
    protected function getItemAttrs()
    {
        return 'property="item" typeof="WebPage"';
    }

    /**
     * @return string
     */
    protected function getNameAttrs()
    {
        return 'property="name"';
    }
}
