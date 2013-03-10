<?php
/**
 * @package    Krizalys.Breadcrumbs
 * @subpackage mod_krizalys_breadcrumbs
 * @copyright  Copyright (C) 2008 - 2013 Krizalys (http://www.krizalys.com/). All rights reserved.
 * @license    GNU General Public License version 3 (http://www.gnu.org/licenses/gpl.html).
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

$item = $list[$i];
$langLink = $i == 1 && !empty($item->link) && !empty($list[$i - 1]->link) && $item->link == $list[$i - 1]->link;

if ($i == 0)
{
	echo '<span xmlns:v="http://rdf.data-vocabulary.org/#">';
}

if (!$langLink)
{
	if ($i > 0)
	{
		echo '<span rel="v:child">';
	}

	echo '<span typeof="v:Breadcrumb">';

	if ($i < $last)
	{
		if (empty($item->link))
		{
			echo '<span property="v:title">' . $item->name . '</span>';
		}

		else
		{
			echo '<a href="' . $item->link . '" rel="v:url" property="v:title">' . $item->name . '</a>';
		}

		if ($i < $count -2)
		{
			echo ' ' . $separator . ' ';
		}
	}

	elseif ($showLast)
	{
		if ($i > 0)
		{
			echo ' ' . $separator . ' ';
		}

		echo '<span property="v:title">' . $item->name . '</span>';
	}
}

++$i;

if ($i < $count)
{
	require __FILE__;
}

--$i;

if (!$langLink)
{
	echo '</span>';

	if ($i > 0)
	{
		echo '</span>';
	}
}

if ($i == 0)
{
	echo '</span>';
}
