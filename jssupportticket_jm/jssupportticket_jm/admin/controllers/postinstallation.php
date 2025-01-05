<?php

/**
 * @Copyright Copyright (C) 2012 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company: Buruj Solutions
  + Contact: www.burujsolutions.com , info@burujsolutions.com
 * Created on:	March 04, 2014
  ^
  + Project: 	JS Tickets
  ^
 */
defined('_JEXEC') or die('Not Allowed');

jimport('joomla.application.component.controller');

class JSSupportticketControllerPostInstallation extends JSSupportTicketController {

    function __construct() {
        parent::__construct();
    }

    function save() {
      JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));
      $data = JFactory::getApplication()->input->post->getArray();
      $result = $this->getJSModel('postinstallation')->storeConfigurations($data);
      $callfrom = $data['step'];
      $link = 'index.php?option=com_jssupportticket&c=postinstallation&layout=steptwo';
      if ($result == SAVED) {
        if ($callfrom == 2) {
          $link = 'index.php?option=com_jssupportticket&c=postinstallation&layout=stepthree';
        } elseif ($callfrom == 3) {
          $link = 'index.php?option=com_jssupportticket&c=postinstallation&layout=settingcomplete';
        } 
      }else{
        $link = 'index.php?option=com_jssupportticket&c=postinstallation&layout='.$data['layout'];
      }
      $this->setRedirect($link);
    }
    
    function display($cachable = false, $urlparams = false) {
      $document = JFactory::getDocument();
      $viewName = 'postinstallation';
      $jinput = JFactory::getApplication()->input;
      $layoutName = $jinput->get('layout');
      $viewType = $document->getType();
      $view = $this->getView($viewName, $viewType);
      $view->setLayout($layoutName);
      $view->display();
    }

}
