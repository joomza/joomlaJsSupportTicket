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

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class JSSupportticketViewJSSupportticket extends JSSupportTicketView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT_ADMINISTRATOR."/views/common.php");
        JToolBarHelper::title(JText::_('Tickets'));
        if ($layoutName == 'controlpanel') {
            JToolBarHelper::title(JText::_('Control Panel'));
            $result = $this->getJSModel('jssupportticket')->getControlPanelData();
            $latestdepartments = $this->getJSModel('department')->getLatestDepartmentsForAdminCP();
            $version = $this->getJSModel('config')->getConfigurationByName('version');
            $this->result = $result;
            $this->latestdepartments = $latestdepartments;
        } elseif ($layoutName == 'aboutus') {
            JToolBarHelper::title(JText::_('About Us'));
        
	} elseif ($layoutName == 'translation') {
            JToolBarHelper::title(JText::_('Language Translations'));
        }
        parent::display($tpl);
    }

}

?>
