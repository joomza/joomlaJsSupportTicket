<?php

/**
 * @Copyright Copyright (C) 2015 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , info@burujsolutions.com
 * Created on:	May 22, 2015
  ^
  + Project: 	JS Tickets
  ^
 */
defined('_JEXEC') or die('Not Allowed');
jimport('joomla.application.component.controller');

class JSSupportticketControllerJSSupportticket extends JSSupportTicketController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function getusersearchajax() {
        JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        $returnvalue = $this->getJSModel('ticket')->getusersearchajax();
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function getlisttranslations(){
        JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        $result = $this->getJSModel('jssupportticket')->getListTranslations();
        echo $result;
        JFactory::getApplication()->close();
    }
    
    function validateandshowdownloadfilename(){
        JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        $langname = JFactory::getApplication()->input->getString('langname');
        $result = $this->getJSModel('jssupportticket')->validateAndShowDownloadFileName( $langname );
        echo $result;
        JFactory::getApplication()->close();
    }

    function getlanguagetranslation(){
        JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        $langname = JFactory::getApplication()->input->getString('langname');
        $filename = JFactory::getApplication()->input->getString('filename');
        $result = $this->getJSModel('jssupportticket')->getLanguageTranslation( $langname , $filename);
        echo $result;
        JFactory::getApplication()->close();
    }


    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = 'jssupportticket';
        $jinput = JFactory::getApplication()->input;
        $layoutName = $jinput->get('layout', 'controlpanel');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $view->setLayout($layoutName);
        $view->display();
    }


}

?>
