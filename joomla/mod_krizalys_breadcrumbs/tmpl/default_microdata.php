<?php
/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2015 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    GNU General Public License version 3 (http://www.gnu.org/licenses/gpl.html).
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

$item = $list[$i];
$langLink = $i == 1 && !empty($item->link) && !empty($list[$i - 1]->link) && $item->link == $list[$i - 1]->link;

if (!$langLink) {
    echo '<span' . ($i > 0 ? ' itemprop="child"' : '') . ' ' . $itemscope . ' itemtype="http://data-vocabulary.org/Breadcrumb">';

    if ($i < $last) {
        if (empty($item->link)) {
            echo '<span itemprop="title">' . $item->name . '</span>';
        } else {
            echo '<a href="'. $item->link . '" itemprop="url" class="pathway"><span itemprop="title">' . $item->name . '</span></a>';
        }

        if ($i < $count - 2) {
            echo ' ' . $separator . ' ';
        }
    } elseif ($showLast) {
        if ($i > 0) {
            echo ' ' . $separator . ' ';
        }

        if ($linkLast) {
            echo '<a href="' . $item->link . '" itemprop="url" class="pathway"><span itemprop="title">' . $item->name . '</span></a>';
        } else {
            echo '<span itemprop="title">' . $item->name . '</span>';
        }
    }
}

++$i;

if ($i < $count) {
    require __FILE__;
}

if (!$langLink) {
    echo '</span>';
}
