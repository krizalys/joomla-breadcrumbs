<?php

/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2015 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    GNU General Public License version 3 (http://www.gnu.org/licenses/gpl.html).
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

class modKrizalysBreadcrumbsHelper
{
    /**
     * @param JRegistry $params
     *
     * @return array
     */
    public static function getList(&$params)
    {
        $app = JFactory::getApplication();
        $pathway = $app->getPathway();
        $items = $pathway->getPathWay();
        $lang = JFactory::getLanguage();
        $menu = $app->getMenu();

        if (JLanguageMultilang::isEnabled()) {
            $home = $menu->getDefault($lang->getTag());
        } else {
            $home = $menu->getDefault();
        }

        $count = count($items);
        $crumbs = array();

        for ($i = 0; $i < $count; ++$i) {
            $crumbs[$i] = new stdClass();
            $crumbs[$i]->name = stripslashes(htmlspecialchars($items[$i]->name, ENT_COMPAT, 'UTF-8'));
            $crumbs[$i]->link = JRoute::_($items[$i]->link);
        }

        if ($params->get('show_home', 1)) {
            $item = new stdClass();
            $item->name = htmlspecialchars($params->get('home_text', JText::_('MOD_KRIZALYS_BREADCRUMBS_HOME')));
            $item->link = JRoute::_('index.php?Itemid=' . $home->id);
            array_unshift($crumbs, $item);
        }

        return $crumbs;
    }

    /**
     * @param null|string $custom
     *
     * @return string
     */
    public static function setSeparator($custom = null)
    {
        $lang = JFactory::getLanguage();

        if ($custom == null) {
            if ($lang->isRTL()) {
                $separator = JHtml::_('image', 'system/arrow_rtl.png', null, null, true);
            } else {
                $separator = JHtml::_('image', 'system/arrow.png', null, null, true);
            }
        } else {
            $separator = htmlspecialchars($custom);
        }

        return $separator;
    }
}
