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

defined ('_JEXEC') or die('Not Allowed');
jimport('joomla.application.component.controller');

class JSSupportTicketControllerticket extends JSSupportTicketController{

	function __construct(){
		parent::__construct();
		$this->registerTask('add', 'edit');
	}

	function saveTicket() {
		JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));
		$Itemid =  JFactory::getApplication()->input->get('Itemid');
		$data = JFactory::getApplication()->input->post->getArray();
		if($data['id'] <> '')
			$id = $data['id'];
		$result = $this->getJSModel('ticket')->storeTicket($data);
		if($result == SAVED){
			$link = 'index.php?option=com_jssupportticket&c=ticket&layout=mytickets&id='.$id.'&Itemid='.$Itemid;
		}elseif($result == SAVE_ERROR || $result == MESSAGE_EMPTY || $result == FILE_EXTENTION_ERROR || $result == TICKET_DUPLICATE){
			JFactory::getApplication()->setUserState('com_jssupportticket.data',$data);
			$link = 'index.php?option=com_jssupportticket&c=ticket&layout=formticket&Itemid='.$Itemid;
		}
        $msg = JSSupportTicketMessage::getMessage($result,'TICKET');
        $this->setRedirect(JRoute::_($link , false), $msg);
    }

    function actionticket() {
    	JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));
		$data = JFactory::getApplication()->input->post->getArray();
		$Itemid =  JFactory::getApplication()->input->get('Itemid');
		$ticketid = $data['ticketid'];
		$action = $data['callfrom'];
		switch($action){
			case 'savemessage':
				//$message = JFactory::getApplication()->input->get('responce', '', 'post', 'string', JREQUEST_ALLOWHTML);
				$message  = JFactory::getApplication()->input->get('responce', '', 'raw');
				$data['message'] = $data['responce'];
				$result = $this->getJSModel('ticketreply')->storeTicketReplies($ticketid, $message, $data['created'], $data);
				$msg = JSSupportTicketMessage::getMessage($result,'MESSAGE');
				$link = 'index.php?option=com_jssupportticket&c=ticket&layout=ticketdetail&id='.$ticketid.'&email='.$data['email'].'&Itemid='.$Itemid;
				$this->setRedirect(JRoute::_($link), $msg);
                break;
			case 'action':
				switch ($data['callaction']){
					case 3:
						$result = $this->getJSModel('ticket')->ticketClose($data['ticketid'],$data['created']);
						$msg = JSSupportTicketMessage::getMessage($result,'CLOSE');
						$link = 'index.php?option=com_jssupportticket&c=ticket&layout=ticketdetail&id='.$data['ticketid'].'&email='.$data['email'].'&Itemid'.$Itemid;
						$this->setRedirect(JRoute::_($link , false), $msg);
						break;
					case 8:
						$result = $this->getJSModel('ticket')->reopenTicket($data['ticketid'],$data['lastreply']);
						$msg = JSSupportTicketMessage::getMessage($result,'REOPEN');
						$link = 'index.php?option=com_jssupportticket&c=ticket&layout=ticketdetail&id='.$data['ticketid'].'&email='.$data['email'].'&Itemid'.$Itemid;
						$this->setRedirect(JRoute::_($link , false), $msg);
						break;
				}
			break;
		}
    }

	function saveresponceajax()  {
		JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		global $mainframe;
		$mainframe = JFactory::getApplication();
		$val = json_decode(JFactory::getApplication()->input->get('val',"","string"),true);
		$id = $val[0];
		$responce = $val[1];
		$result = $this->getJSModel('ticket')->saveResponceAJAX($id,$responce);
		$msg = JSSupportTicketMessage::getMessage($result,'MESSAGE');
		if($result == SAVED){
			$result = 1;
		}else{
			$result = '<font color="red">'.$msg.'</font>';
		}
		echo $result;
		$mainframe->close();
	}

	function editresponce()  {
		JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		global $mainframe;
		$mainframe = JFactory::getApplication();
		$id = JFactory::getApplication()->input->get('id');
		$result = $this->getJSModel('ticket')->editResponceAJAX($id);
		echo $result;
		$mainframe->close();
	}

	function deleteresponceajax() {
		JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		global $mainframe;
		$mainframe = JFactory::getApplication();
		$id = JFactory::getApplication()->input->get('id');
		$result = $this->getJSModel('ticket')->deleteResponceAJAX($id);
		$msg = JSSupportTicketMessage::getMessage($result,'MESSAGE');
		if ($result == DELETED){
			$result = '<font color="green">'.$msg.'</font>';
		}elseif($result == PERMISSION_ERROR){
			$result = '<font color="red">'.$msg.'</font>';
		}else{
			$result = '<font color="red">'.$msg.'</font>';
		}
		echo $result;
		$mainframe->close();
	}

	function getmytickets(){
		$data = JFactory::getApplication()->input->post->getArray();
		$Itemid =  JFactory::getApplication()->input->get('Itemid');
		$email = $data['email'];
		$ticketid = $data['ticketid'];
		$model = $this->getJSModel('ticket');
		$result = $model->checkEmailAndTicketID($email,$ticketid);
	}

	function getdownloadbyid(){
		JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		$id = JFactory::getApplication()->input->get('id');
		$this->getJSModel('ticket')->getDownloadAttachmentById($id);
		JFactory::getApplication()->close();
	}

    function downloadbyname(){

        $id = JFactory::getApplication()->input->get('id');
        $name = JFactory::getApplication()->input->get('name');
        $this->getJSModel('ticket')->getDownloadAttachmentByName( $name, $id );

        JFactory::getApplication()->close();
    }

    function datafordepandantfield() {
    	JSession::checkToken( 'get' ) or die( 'Invalid Token' );
        //JSession::checkToken() or die( 'Invalid Token' );
        $val = JFactory::getApplication()->input->get('fvalue');
        $childfield = JFactory::getApplication()->input->get('child');
        $result = $this->getJSModel('userfields')->dataForDepandantField( $val , $childfield);
        $result = json_encode($result);
        echo $result;
        JFactory::getApplication()->close();
    }

	function display($cachable = false, $urlparams = false){
		$document = JFactory::getDocument();
		$viewName = JFactory::getApplication()->input->post->get('view','ticket');
		$layoutName = JFactory::getApplication()->input->get('layout','mytickets');
		$viewType = $document->getType();
		$view = $this->getView($viewName, $viewType);
		$view->setLayout($layoutName);
		$view->display();
	}
}
?>
