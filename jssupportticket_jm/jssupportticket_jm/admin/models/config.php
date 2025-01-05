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

class JSSupportticketModelConfig extends JSSupportTicketModel {

    function __construct() {
        parent::__construct();
    }

    function getConfiguration() { // Layout Configurations
        $db = $this->getDbo();
        $query = "SELECT * FROM `#__js_ticket_config`";
        $db->setQuery($query);
        $results = $db->loadObjectList();
        if ($results) {
            foreach ($results as $result) {
                $config[$result->configname] = $result->configvalue;
            }
        }
        $lists['priorities'] = $this->getJSModel('priority')->getPrioritiesForCombobx();
        $lists['emails'] = $this->getJSModel('email')->getEmailForCombobox();
        $result_value[0] = $config;
        $result_value[1] = $lists;
        return $result_value;
    }

    function storeConfig() {
        $row = $this->getTable('config');
        $data = JFactory::getApplication()->input->post->getArray();

        $data_directory = $data['data_directory'];
        if(empty($data_directory)){
            return 2;
        }
        if (strpos($data_directory, 'com_jssupportticket') !== false) {
            return 2;
        }
        $path = JPATH_ROOT.'/'.$data_directory;
        if ( ! file_exists($path)) {
            mkdir($path, 0755);
        }
        if( ! is_writeable($path)){
            return 3;
        }

        if (!isset($data['new_ticket_alert_admin']))
            $data['new_ticket_alert_admin'] = 0;
        if (!isset($data['new_ticket_alert_department']))
            $data['new_ticket_alert_department'] = 0;
        if (!isset($data['new_message_alert_last_respondent']))
            $data['new_message_alert_last_respondent'] = 0;
        if (!isset($data['new_message_alert_assigned_staff']))
            $data['new_message_alert_assigned_staff'] = 0;
        if (!isset($data['new_internal_note_alert_last_respondent']))
            $data['new_internal_note_alert_last_respondent'] = 0;
        if (!isset($data['new_internal_note_alert_assigned_staff']))
            $data['new_internal_note_alert_assigned_staff'] = 0;
        if (!isset($data['overdue_ticket_alert_department']))
            $data['overdue_ticket_alert_department'] = 0;
        if (!isset($data['overdue_ticket_alert_assigned_staff']))
            $data['overdue_ticket_alert_assigned_staff'] = 0;
        if (!isset($data['sys_errors_sql']))
            $data['sys_errors_sql'] = 0;
        if (!isset($data['sys_errors_login']))
            $data['sys_errors_login'] = 0;
        if($data['controlpanel_column_count'] < 1 || $data['controlpanel_column_count'] > 12)
            $data['controlpanel_column_count'] = 3;
        $config = array();

        foreach ($data as $key => $value) {
            $config['configname'] = $key;
            $config['configvalue'] = $value;
            if (!$row->bind($config)) {
                $this->setError($row->getError());
                return false;
            }
            if (!$row->store()) {
                $this->setError($row->getError());
                $this->getJSModel('systemerrors')->updateSystemErrors($row->getError());
                return false;
            }
        }
        return true;
    }

    function getConfigrefer() {
        $db = JFactory::getDBO();
        $query = "SELECT * FROM `#__js_ticket_config` WHERE configname = 'tvalue' OR configname = 'versioncode' OR configname = 'version' OR configname = 'versiontype'";
        $db->setQuery($query);
        $confs = $db->loadObjectList();
        foreach ($confs AS $conf) {
            if ($conf->configname == 'tvalue') {
                $value = $conf->configvalue;
            }
            if ($conf->configname == 'versioncode') {
                $vcode = $conf->configvalue;
            }
            if ($conf->configname == 'version') {
                $version = $conf->configvalue;
            }
            if ($conf->configname == 'versiontype') {
                $vtype = $conf->configvalue;
            }
        }
        if ($value == '0') {
            $row = $this->getTable('config');
            $reser_med = date('yHmsiyd');
            $reser_med = md5($reser_med);
            $reser_med = md5($reser_med);
            $reser_med = substr($reser_med, 1, 10);
            $reser_med = md5($reser_med);
            $string = md5(time());
            $reser_start = substr($string, 4, 7);
            $reser_end = substr($reser_med, 7, 17);
            $value = $reser_start . $reser_med . $reser_end;

            $config['configname'] = 'tvalue';
            $config['configvalue'] = $value;
            if (!$row->bind($config)) {
                $this->setError($row->getError());
                return false;
            }
            if (!$row->store()) {
                $this->setError($row->getError());
                $this->getJSModel('systemerrors')->updateSystemErrors($row->getError());
                return false;
            }
        }

        $result[0] = $value;
        $result[1] = $vcode;
        $result[2] = $version;
        $result[3] = $vtype;

        return $result;
    }

    function getConfigByFor($configfor){
        $db = $this->getDBO();
        $query = "SELECT * FROM `#__js_ticket_config` WHERE configfor = ".$db->quote($configfor);
        $db->setQuery($query);
        $config = $db->loadObjectList();
        $configs = array();
        foreach($config as $conf)   {
                $configs[$conf->configname] =  $conf->configvalue;
        }
        return $configs;
    }

    function getConfigs(){
        $db = $this->getDBO();
        $query = "SELECT * FROM `#__js_ticket_config` ";
        $db->setQuery($query);
        $config = $db->loadObjectList();
        $configs = array();
        foreach($config as $conf)   {
                $configs[$conf->configname] =  $conf->configvalue;
        }
        return $configs;
    }

    function getEmailReadTime() {
        $db = JFactory::getDbo();
        $time = null;
        $query = "SELECT config.configvalue FROM `#__js_ticket_config` AS config WHERE config.configname = 'lastEmailReadingTime'";
        $db->setQuery($query);
        $time = $db->loadResult();
        return $time;
    }

    function setEmailReadTime($time) {
        $db = JFactory::getDbo();
        $query = "UPDATE `#__js_ticket_config` set configvalue = ".$db->quote($time)." WHERE configname = 'lastEmailReadingTime'";
        $db->setQuery($query);
        $db->execute();
    }

    function getConfigurationByName($configname){
        $db = JFactory::getDbo();
        $query = "SELECT configvalue FROM `#__js_ticket_config` WHERE configname = ".$db->quote($configname);
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }
}

?>
