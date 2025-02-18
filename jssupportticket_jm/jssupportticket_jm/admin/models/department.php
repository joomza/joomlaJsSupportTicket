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

jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSSupportticketModelDepartment extends JSSupportTicketModel {

    function __construct() {
        parent::__construct();
    }

    function getAllDepartments($searchdepartment,$limitstart,$limit){//$searchdepartment, $searchtype,$limitstart,$limit
       /* $type[] = array('value'=>'' ,'text'=>  JText::_('Select type'));
        $type[] = array('value'=>1 ,'text'=>  JText::_('Public'));
        $type[] = array('value'=>0 ,'text'=>  JText::_('Private'));
        $lists['type'] = JHTML::_('select.genericList', $type, 'filter_type', 'class="inputbox tk_department_select" ', 'value', 'text', $searchtype);*/
        $lists = array();
        $db = $this->getDbo();
        //For Total Record
        $wherequery="";
        if(isset($searchdepartment) && $searchdepartment != ''){
            $searchdepartment = trim($searchdepartment);
            $wherequery .= " AND dep.departmentname LIKE ".$db->quote('%'.$searchdepartment.'%');
        }
        /*if(isset($searchtype) && $searchtype != ''){
            if(!is_numeric($searchtype)) return false;
            $wherequery .= " AND dep.ispublic =".$searchtype;
        }*/


        $query = "SELECT COUNT(id) From `#__js_ticket_departments` AS dep WHERE dep.status <> -1 ";
        $query.=$wherequery;
        $db->setQuery($query);
        $total =$db->loadResult();

        //dep.ispublic,
        $query = "SELECT dep.id,dep.isdefault, dep.departmentname,dep.status ,dep.created, dep.update,        
        (SELECT email.email From `#__js_ticket_email` AS email WHERE email.id=dep.emailid) AS outgoingemail        
        From`#__js_ticket_departments`AS dep WHERE dep.status <> -1";
        $query.=$wherequery;

        $db->setQuery($query,$limitstart,$limit);
        $departments = $db->loadObjectList();

        if($searchdepartment) $lists['searchdepartment'] = $searchdepartment;
        $result[0] = $departments;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function getDepartmentForForm($id){
        if($id) if(!is_numeric($id)) return false;
        $db = $this->getDbo();
        if($id){
            $query = "SELECT * FROM `#__js_ticket_departments` WHERE id =".$id;
            $db->setQuery($query);
            $department = $db->loadObject();
        }
        $emailid = '';
        if(isset ($department)){
            $emailtemplateid = $department->emailtemplateid;
            $emailid = $department->emailid;
        }
        // $type = array(array('value' => null, 'text' => JText::_('Type')), array('value' => 0, 'text' => JText::_('Private')), array('value' => 1, 'text' => JText::_('Public')));
        $status = array(array('value' => null, 'text' => JText::_('Status')),array('value' => 0, 'text' => JText::_('Disabled')),array('value' => 1, 'text' => JText::_('Active')));
        $isdefault = array(array('value' => 0, 'text' => JText::_('Not default')),array('value' => 1, 'text' => JText::_('Default')));
        if(isset($department)){
            $lists['isdefault'] = JHTML::_('select.genericList', $isdefault, 'isdefault', 'class="inputbox js-ticket-form-field-input" ' . '', 'value', 'text',$department->isdefault);
            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox js-ticket-form-field-input " ' . '', 'value', 'text',$department->status);
            //$lists['type'] = JHTML::_('select.genericList', $type, 'ispublic', 'class="inputbox required " ' . '', 'value', 'text',$department->ispublic);
        }else{
            $lists['isdefault'] = JHTML::_('select.genericList', $isdefault, 'isdefault', 'class="inputbox js-ticket-form-field-input " ' . '', 'value', 'text',0);
            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox js-ticket-form-field-input " ' . '', 'value', 'text',1);
            //$lists['type'] = JHTML::_('select.genericList', $type, 'ispublic', 'class="inputbox required " ' . '', 'value', 'text','');
        }
        
        $emaillist = $this->getJSModel('email')->getEmailForCombobox(JText::_('Select email'));
        $lists['emaillist'] =JHTML::_('select.genericList', $emaillist, 'emailid', 'class="inputbox required" '. '', 'value', 'text',$emailid);
        
        if(isset($department)) 
            $result[0] = $department;
        $result[1] = $lists;
        return $result;
    }

    function getDepartments(){
        $db = $this->getDBO();
        $query = "SELECT * FROM `#__js_ticket_departments` WHERE status = 1 ";//AND ispublic = 1
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $departments = array();
        $departments[] =  array('value' => null,  'text' => JText::_('Select Department'));
        foreach($rows as $row){
                $departments[] = array('value' => $row->id, 'text' => JText::_($row->departmentname));
        }
        return $departments;
    }

    function getDepartmentsForCombobox(){
        $db = $this->getDBO();
        $query = "SELECT * FROM `#__js_ticket_departments` WHERE status = 1 AND ispublic = 1";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $departments = array();
        $departments[] =  array('value' => '',  'text' => JText::_('Select Department'));
        foreach($rows as $row){
                $departments[] =  array('value' => $row->id,'text' => $row->departmentname);
        }
        return $departments;
    }

    function getFormData($id) {
        $db = $this->getDbo();
        $email;
        if (isset($id)) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT * FROM `#__js_ticket_departments` WHERE id =" . $id;
            $db->setQuery($query);
            $department = $db->loadObject();
        }
        if (isset($department)) {
            $emailtemplateid = $department->emailtemplateid;
            $emailid = $department->emailid;
        }
        $emaillist = $this->getJSModel('email')->getEmailForCombobox(JText::_('Select email'));
        $lists['emaillist'] = JHTML::_('select.genericList', $emaillist, 'emailid', 'class="inputbox required" ' . '', 'value', 'text');

        $result[0] = $department;
        $result[2] = $lists;
        return $result;
    }

    function storeDepartment($data) {
        $user = JSSupportticketCurrentUser::getInstance();
        $row = $this->getTable('departments');
        if (!$row->bind($data)) {
            $this->setError($row->getError());
            return SAVE_ERROR;
        }
        if (!$row->check()) {
            $this->setError($row->getError());
            return SAVE_ERROR;
        }
        if (!$row->store()) {
            $this->getJSModel('systemerrors')->updateSystemErrors($row->getError());
            $this->setError($row->getError());
            return SAVE_ERROR;
        }
        JSSupportticketMessage::$recordid = $row->id;
        return SAVED;
    }

    function deleteDepartment(){
        $db = $this->getDBO();
        $cids = JFactory::getApplication()->input->get('cid',array(0),'','array');
        foreach($cids AS $id){
            if(!is_numeric($id)) return false;
            if($this->departmentCanDelete($id) == true){
                $query = "DELETE department FROM `#__js_ticket_departments` AS department WHERE department.id = ".$id;
                $db->setQuery($query);
                if (!$db->execute()) {
                    $this->getJSModel('systemerrors')->updateSystemErrors($db->getErrorMsg());
                    $this->setError($db->getErrorMsg());
                    return DELETE_ERROR;
                }
                return DELETED;
            }else{
                return IN_USE;
            }
        }
    }

    function deleteDepartmentAdmin() {
        $row = $this->getTable('departments');
        $db =  $this->getDBO();
        $c_id = JFactory::getApplication()->input->get('cid', array(0), '', 'array');
        $delete = 0;
        foreach ($c_id as $id) {
            if(is_numeric($id)){
                if ($this->departmentCanDelete($id) == true) {
                    $query = "DELETE department
                         FROM `#__js_ticket_departments` AS department 
                         WHERE department.id = " . $id;
                    $db->setQuery($query);
                    if (!$db->execute()) {
                        return DELETE_ERROR;
                    }
                }else{
                    return DELETE_ERROR;
                }
            }else{
                return false;
            }
        }
        return DELETED;
    }

    function departmentCanDelete($id){
        if(!is_numeric($id)) return false;
        $db = $this->getDBO();
        $query = "SELECT( (SELECT count(id) FROM `#__js_ticket_tickets` where departmentid=".$id." )
                        ) AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if($total > 0) return false;
        else return true;
    }

     function getDepartmentById($id) {
        if (!is_numeric($id))
            return false;
        $db = $this->getDBO();
        $query = "SELECT departmentname FROM `#__js_ticket_departments` WHERE id = " . $id;
        $db->setQuery($query);
        $departmentname = $db->loadResult();
        return $departmentname;
    }

    function getLatestDepartmentsForAdminCP(){

        $db = $this->getDBO();
        $query = "SELECT departmentname,departmentsignature,id
                    FROM `#__js_ticket_departments`
                    ORDER BY created DESC";
        $db->setQuery($query,0, 5);
        $result = $db->loadObjectList();
        return $result;
    }
    
}
?>
