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

    public function isUseXhtml()
    {
        return $this->useXhtml;
    }

    private function getMetaTag($index)
    {
        $tag = '<meta property="position" content="' . $index . '"';

        if ($this->isUseXhtml()) {
            $tag .= ' /';
        }

        $tag .= '>';
        return $tag;
    }

    abstract protected function getContainerAttrs();

    abstract protected function getItemContainerAttrs();

    abstract protected function getItemAttrs();

    abstract protected function getNameAttrs();

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

        $html .= '<li ' . $attrs . '>';

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

        if ($i != $iLast) {
            $html .= '<span class="divider">' . $this->separator . '</span>';
        }

        $html .= '</li>';
        return $html;
    }

    private function renderContainer(array $items)
    {
        $nItems = count($items);
        $iLast  = $nItems - 1;

        $html = '<ul class="breadcrumb' .  $this->moduleclassSfx
            . ' krizalys_breadcrumb' . $this->moduleclassSfx . '" '
            . $this->getContainerAttrs() . '>';

        $here = $this->showHere ?
            JText::_('MOD_KRIZALYS_BREADCRUMBS_HERE') . '&nbsp;'
            : '<span class="divider icon-location"></span>';

        $html .= '<li class="active">' . $here . '</li>';

        foreach ($items as $i => $item) {
            $isLast = $i == $iLast;

            if (!$isLast || $this->showLast) {
                $html .= $this->renderItem($items, $i,
                    !$isLast || $this->linkLast, $isLast);
            }
        }

        $html .= '</ul>';
        return $html;
    }

    public function render(array $items)
    {
        return $this->renderContainer($items);
    }
}
