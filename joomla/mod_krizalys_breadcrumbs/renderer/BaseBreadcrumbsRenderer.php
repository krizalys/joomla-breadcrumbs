<?php

/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2023 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    3-Clause BSD License (https://opensource.org/licenses/BSD-3-Clause).
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

abstract class BaseBreadcrumbsRenderer
{
    /**
     * @var string
     */
    private $moduleclassSfx;

    /**
     * @var bool
     */
    private $showHere;

    /**
     * @var bool
     */
    private $showHome;

    /**
     * @var bool
     */
    private $showLast;

    /**
     * @var bool
     */
    private $linkLast;

    /**
     * @var bool
     */
    private $useXhtml;

    /**
     * @var string
     */
    private $separator;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->moduleclassSfx = array_key_exists('moduleclass_sfx', $options) ? (string) $options['moduleclass_sfx'] : '';
        $this->showHere       = array_key_exists('show_here', $options) ? (bool) $options['show_here'] : false;
        $this->showHome       = array_key_exists('show_home', $options) ? (bool) $options['show_home'] : false;
        $this->showLast       = array_key_exists('show_last', $options) ? (bool) $options['show_last'] : false;
        $this->linkLast       = array_key_exists('link_last', $options) ? (bool) $options['link_last'] : false;
        $this->useXhtml       = array_key_exists('use_xhtml', $options) ? (bool) $options['use_xhtml'] : false;
        $this->separator      = array_key_exists('separator', $options) ? (string) $options['separator'] : '';
    }

    /**
     * @return bool
     */
    public function isUseXhtml()
    {
        return $this->useXhtml;
    }

    /**
     * @return string
     */
    private function getSeparator()
    {
        $separator = $this->separator;
        $separator = '<span class="divider">' . $separator . '</span>';
        return $separator;
    }

    /**
     * @param int $index
     *
     * @return string
     */
    abstract protected function getMetaTag($index);

    /**
     * @return string
     */
    abstract protected function getContainerAttrs();

    /**
     * @return string
     */
    abstract protected function getItemContainerAttrs();

    /**
     * @return string
     */
    abstract protected function getItemAttrs();

    /**
     * @return string
     */
    abstract protected function getNameAttrs();

    /**
     * @param array $items
     * @param int   $i
     * @param bool  $link
     * @param bool  $last
     *
     * @return string
     */
    private function renderItem(array $items, $i, $link = true, $last = false)
    {
        $nItems = count($items);
        $iLast  = $this->showLast ? $nItems - 1 : $nItems - 2;
        $item   = $items[$i];
        $html   = '';
        $attrs  = $this->getItemContainerAttrs();

        if ($last) {
            $attrs .= ' class="active"';
        }

        $html .= '<li ' . $attrs . ">\n";

        if (!$link || empty($item->link)) {
            $html .= '<span ' . $this->getItemAttrs();

            if (!empty($item->id)) {
                $html .= ' itemscope itemtype="http://schema.org/Thing" itemid="' . $item->id . '"';
            }

            $html .= '>';
        } else {
            $html .= '<a href="' . $item->link . '" class="pathway" '
                . $this->getItemAttrs() . '>';
        }

        $attrs  = $this->getNameAttrs();
        $html  .= '<span ' . $attrs . '>' . $item->name . '</span>';

        if (!$link || empty($item->link)) {
            $html .= "</span>\n";
        } else {
            $html .= "</a>\n";
        }

        $html .= $this->getMetaTag($i + 1) . "\n";

        if ($i != $iLast) {
            $html .= $this->getSeparator() . "\n";
        }

        $html .= "</li>\n";
        return $html;
    }

    /**
     * @param array $items
     *
     * @return string
     */
    private function renderContainer(array $items)
    {
        $nItems = count($items);
        $iLast  = $nItems - 1;

        $html = '<ul class="breadcrumb' .
            $this->moduleclassSfx . ' krizalys_breadcrumb'
            . $this->moduleclassSfx . '" ' . $this->getContainerAttrs() . ">\n";

        $here = $this->showHere ?
            JText::_('MOD_KRIZALYS_BREADCRUMBS_HERE') . '&nbsp;'
            : '<span class="divider icon-location"></span>';

        $html .= "<li class=\"active\">\n"
            . $here . "\n"
            . "</li>\n";

        foreach ($items as $i => $item) {
            $isLast = $i == $iLast;

            if (!$isLast || $this->showLast) {
                $html .= $this->renderItem($items, $i,
                    !$isLast || $this->linkLast, $isLast);
            }
        }

        $html .= "</ul>\n";
        return $html;
    }

    /**
     * @param array $items
     *
     * @return string
     */
    public function render(array $items)
    {
        return $this->renderContainer($items);
    }
}
