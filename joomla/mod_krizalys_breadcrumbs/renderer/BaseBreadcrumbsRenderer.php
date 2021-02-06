<?php

/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2021 Krizalys (http://www.krizalys.com/). All rights reserved.
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
     * @var string
     */
    private $tagContainer;

    /**
     * @var string
     */
    private $tagHere;

    /**
     * @var string
     */
    private $classHere;

    /**
     * @var bool
     */
    private $markerHere;

    /**
     * @var string
     */
    private $tagItemContainer;

    /**
     * @var bool
     */
    private $wrapSeparator;

    /**
     * @var bool
     */
    private $detachSeparator;

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

        // Detect Joomla! version to apply matching markup.
        $version = new JVersion();
        $joomla3 = $version->isCompatible('3.0');

        if ($joomla3) {
            $this->tagContainer     = 'ul';
            $this->tagHere          = 'li';
            $this->classHere        = 'active';
            $this->markerHere       = true;
            $this->tagItemContainer = 'li';
            $this->wrapSeparator    = true;
            $this->detachSeparator  = false;
        } else {
            $this->tagContainer     = 'div';
            $this->tagHere          = 'span';
            $this->classHere        = 'showHere';
            $this->markerHere       = false;
            $this->tagItemContainer = 'span';
            $this->wrapSeparator    = false;
            $this->detachSeparator  = true;
        }
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

        if ($this->wrapSeparator) {
            $separator = '<span class="divider">' . $separator . '</span>';
        }

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

        $html .= '<' . $this->tagItemContainer . ' ' . $attrs . ">\n";

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

        if (!$this->detachSeparator && $i != $iLast) {
            $html .= $this->getSeparator() . "\n";
        }

        $html .= $this->getMetaTag($i + 1) . "\n";
        $html .= '</' . $this->tagItemContainer . ">\n";
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

        $html = '<' . $this->tagContainer . ' class="breadcrumb' .
            $this->moduleclassSfx . ' krizalys_breadcrumb'
            . $this->moduleclassSfx . '" ' . $this->getContainerAttrs() . ">\n";

        if ($this->markerHere) {
            $here = $this->showHere ?
                JText::_('MOD_KRIZALYS_BREADCRUMBS_HERE') . '&nbsp;'
                : '<span class="divider icon-location"></span>';
        } else {
            $here = JText::_('MOD_KRIZALYS_BREADCRUMBS_HERE');
        }

        $html .= '<' . $this->tagHere . ">\n"
            . $here . "\n"
            . '</' . $this->tagHere . ">\n";

        foreach ($items as $i => $item) {
            $isLast = $i == $iLast;

            if (!$isLast || $this->showLast) {
                if ($this->detachSeparator && 0 < $i) {
                    $html .= ' ' . $this->getSeparator() . ' ';
                }

                $html .= $this->renderItem($items, $i,
                    !$isLast || $this->linkLast, $isLast);
            }
        }

        $html .= '</' . $this->tagContainer . ">\n";
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
