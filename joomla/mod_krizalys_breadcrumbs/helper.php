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
    public static function getList(&$params)
    {
        $app = JFactory::getApplication();
        $pathway = $app->getPathway();
        $items = $pathway->getPathWay();
        $count = count($items);

        for ($i = 0; $i < $count; ++$i) {
            $items[$i]->name = stripslashes(htmlspecialchars($items[$i]->name, ENT_COMPAT, 'UTF-8'));
            $items[$i]->link = JRoute::_($items[$i]->link);
        }

        if ($params->get('show_home', 1)) {
            $item = new stdClass();
            $item->name = htmlspecialchars($params->get('home_text', JText::_('MOD_KRIZALYS_BREADCRUMBS_HOME')));
            $item->link = JRoute::_('index.php?Itemid=' . $app->getMenu()->getDefault()->id);
            array_unshift($items, $item);
        }

        return $items;
    }

    public static function setSeparator($custom = null)
    {
        $lang = JFactory::getLanguage();

        if ($custom == null) {
            if ($lang->isRTL()) {
                $_separator = JHtml::_('image', 'system/arrow_rtl.png', null, null, true);
            } else {
                $_separator = JHtml::_('image', 'system/arrow.png', null, null, true);
            }
        } else {
            $_separator = htmlspecialchars($custom);
        }

        return $_separator;
    }
}
