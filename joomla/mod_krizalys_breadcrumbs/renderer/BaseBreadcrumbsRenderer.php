<?php
/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2015 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    GNU General Public License version 3 (http://www.gnu.org/licenses/gpl.html).
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

abstract class BaseBreadcrumbsRenderer
{
    private $moduleclassSfx;
    private $showHere;
    private $showHome;
    private $showLast;
    private $linkLast;
    private $useXhtml;
    private $separator;
    private $tagContainer;
    private $tagHere;
    private $classHere;
    private $markerHere;
    private $tagItemContainer;
    private $wrapSeparator;
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
     * @param int $index
     *
     * @return string
     */
    private function getMetaTag($index)
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
    private function getSeparator()
    {
        $separator = $this->separator;

        if ($this->wrapSeparator) {
            $separator = '<span class="divider">' . $separator . '</span>';
        }

        return $separator;
    }

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

        $html .= '<' . $this->tagItemContainer . ' ' . $attrs . '>';

        if (!$link || empty($item->link)) {
            $html .= '<span ' . $this->getItemAttrs() . '>';
        } else {
            $html .= '<a href="' . $item->link . '" class="pathway" '
                . $this->getItemAttrs() . '>';
        }

        $attrs  = $this->getNameAttrs();
        $html  .= '<span ' . $attrs . '>' . $item->name . '</span>';

        if (!$link || empty($item->link)) {
            $html .= '</span>';
        } else {
            $html .= '</a>';
        }

        $html .= $this->getMetaTag($i + 1);

        if (!$this->detachSeparator && $i != $iLast) {
            $html .= $this->getSeparator();
        }

        $html .= '</' . $this->tagItemContainer . '>';
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
            . $this->moduleclassSfx . '" ' . $this->getContainerAttrs() . '>';

        if ($this->markerHere) {
            $here = $this->showHere ?
                JText::_('MOD_KRIZALYS_BREADCRUMBS_HERE') . '&nbsp;'
                : '<span class="divider icon-location"></span>';
        } else {
            $here = JText::_('MOD_KRIZALYS_BREADCRUMBS_HERE');
        }

        $html .= '<' . $this->tagHere . ' class="' . $this->classHere . '">'
            . $here . '</' . $this->tagHere . '>';

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

        $html .= '</' . $this->tagContainer . '>';
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
