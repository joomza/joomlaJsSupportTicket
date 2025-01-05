<?php
/**
 * @Copyright Copyright (C) 2012 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , info@burujsolutions.com
 * Created on:	May 03, 2012
 ^
 + Project: 	JS Tickets
 ^
*/

defined('_JEXEC') or die('Restricted access');

	global $sorton,$sortorder;
	$option = 'com_jssupportticket';
	$mainframe = JFactory::getApplication();
	$itemid = JFactory::getApplication()->input->get('Itemid');
	$type = 'offl';
	$config =  $this->getJSModel('config')->getConfigs();
	$layoutName = JFactory::getApplication()->input->get('layout', '');
    $user = JSSupportTicketCurrentUser::getInstance();
    $isguest = $user->getIsGuest();
    $uid = $user->getId();
    $uname = $user->getName();
	$limit = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
//	$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$limitstart = JFactory::getApplication()->input->get('limitstart',0);

	$needlogin = false;
	switch($layoutName){
		case 'formticket':
		case 'mytickets' :
		case 'adderasedatarequest':
			$needlogin = true;
		break;
	}
	if($needlogin == true){
		if($isguest){
			$redirectUrl = 'index.php?option=com_jssupportticket&c=ticket&layout='.$layoutName.'&Itemid='.$itemid;
			$redirectUrl = '&amp;return='.base64_encode($redirectUrl);
			$finalUrl = 'index.php?option=com_users&view=login'. $redirectUrl;
			//$msg = JText::_('Login required');
	        $msg = JText::_('To access the private area of the site').'. '.JText::_('Please log in').'.';
	        $app = JFactory::getApplication();
	        $app->enqueueMessage($msg, 'fail');
	        $app->redirect($finalUrl);
	        //$mainframe->redirect($finalUrl, $msg);

		}
	}
	$this->layoutname = $layoutName;
	$this->config = $config;
	$this->Itemid = $itemid;
	$this->option = $option;
	$this->user = $user;
?>
