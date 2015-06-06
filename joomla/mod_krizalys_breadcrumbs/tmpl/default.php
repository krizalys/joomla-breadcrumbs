<?php
/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2015 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    GNU General Public License version 3 (http://www.gnu.org/licenses/gpl.html).
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');
?>
<div class="krizalys_breadcrumb<?php echo $moduleclassSfx; ?>"<?php if ($format == 'RDFa') echo ' xmlns:v="http://rdf.data-vocabulary.org/#"'; ?>>
    <?php if ($showHere): ?>
    <span class="showHere"><?php echo JText::_('MOD_KRIZALYS_BREADCRUMBS_HERE'); ?></span>
    <?php endif; ?>
    <?php
    $i = 0;

    if ($format == 'RDFa') {
        require JModuleHelper::getLayoutPath('mod_krizalys_breadcrumbs', $params->get('layout', 'default_rdfa'));
    } else {
        require JModuleHelper::getLayoutPath('mod_krizalys_breadcrumbs', $params->get('layout', 'default_microdata'));
    }
    ?>
</div>
