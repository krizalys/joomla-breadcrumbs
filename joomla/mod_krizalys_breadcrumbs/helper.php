<?php

/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2023 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    3-Clause BSD License (https://opensource.org/licenses/BSD-3-Clause).
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
            $crumbs[$i]->id = JRoute::_($items[$i]->link, true, -1);
            $crumbs[$i]->name = stripslashes(htmlspecialchars($items[$i]->name, ENT_COMPAT, 'UTF-8'));
            $crumbs[$i]->link = JRoute::_($items[$i]->link);
        }

        if ($params->get('show_home', 1)) {
            $item = new stdClass();
            $item->id = JRoute::_('index.php?Itemid=' . $home->id, true, -1);
            $item->name = htmlspecialchars($params->get('home_text', JText::_('MOD_KRIZALYS_BREADCRUMBS_HOME')));
            $item->link = JRoute::_('index.php?Itemid=' . $home->id);
            array_unshift($crumbs, $item);
        }

        /**
         * Force-link last item if it is not in menu.
         *
         * @see https://github.com/krizalys/joomla-breadcrumbs/issues/1
         */
        if ($params->get('link_last', 1)) {
            end($crumbs);
            $last = key($crumbs);

            if (empty($crumbs[$last]->link)) {
                $crumbs[$last]->id = JURI::current();
                $crumbs[$last]->link = JURI::current();
            }
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
