<?php
/**
 * @Copyright Copyright (C) 2015 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:    www.burujsolutions.com , info@burujsolutions.com
 * Created on:  May 22, 2015
  ^
  + Project:    JS Tickets
  ^
 */

defined('_JEXEC') or die('Restricted access');
	$commonpath="index.php?option=com_jssupportticket";
	$pathway = $mainframe->getPathway();
	if ($config['cur_location'] == 1) {
		$pathway->addItem(JText::_('Control panel'), $commonpath.'&c=jssupportticket&layout=controlpanel');
		switch($layoutName){
			case 'adderasedatarequest':
				$pathway->addItem(JText::_('Erase Data Request'), $commonpath."&c=ticket&layout=formticket&Itemid=".$itemid);
			break;
		}
	}

?>

