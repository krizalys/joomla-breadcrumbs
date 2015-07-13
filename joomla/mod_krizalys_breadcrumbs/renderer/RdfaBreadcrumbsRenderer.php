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

class RdfaBreadcrumbsRenderer extends BaseBreadcrumbsRenderer
{
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
