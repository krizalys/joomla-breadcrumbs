<?php
/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2015 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    GNU General Public License version 3 (http://www.gnu.org/licenses/gpl.html).
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

require_once dirname(__FILE__) . '/helper.php';
$moduleclassSfx = htmlspecialchars($params->get('moduleclass_sfx'));
$list = modKrizalysBreadcrumbsHelper::getList($params);
$count = count($list);
$last = $count - 1;
$showHere = (bool) $params->get('show_here', true);
$showHome = (bool) $params->get('show_home', true);
$showLast = (bool) $params->get('show_last', true);
$linkLast = (bool) $params->get('link_last', false);
$useXhtml = (bool) $params->get('use_xhtml', false);
$format = $params->get('format', 'microdata');
$separator = modKrizalysBreadcrumbsHelper::setSeparator($params->get('separator'));
require JModuleHelper::getLayoutPath('mod_krizalys_breadcrumbs', $params->get('layout', 'default'));
