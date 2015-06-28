<?php
/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2015 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    GNU General Public License version 3 (http://www.gnu.org/licenses/gpl.html).
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

$options = array(
    'moduleclass_sfx' => $moduleclassSfx,
    'show_here'       => $showHere,
    'show_last'       => $showLast,
    'link_last'       => $linkLast,
    'use_xhtml'       => $useXhtml,
    'separator'       => $separator
);

switch ($format) {
    case 'RDFa':
        require_once __DIR__ . '/../renderer/RdfaBreadcrumbsRenderer.php';
        $renderer = new RdfaBreadcrumbsRenderer($options);
        break;

    default:
        require_once __DIR__ . '/../renderer/MicrodataBreadcrumbsRenderer.php';
        $renderer = new MicrodataBreadcrumbsRenderer($options);
        break;
}

echo $renderer->render($list);
