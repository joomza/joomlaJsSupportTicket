<?php

/**
 * @Copyright Copyright (C) 2015 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	May 22, 2015
 ^
 + Project: 	JS Tickets
 ^ 
*/
defined('_JEXEC') or die('Restricted access');

class com_jssupportticketInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		// $parent is the class calling this method
		//$parent->getParent()->setRedirectURL('index.php?option=com_jsdocumentation');
		$parent->getParent()->setRedirectURL('index.php?option=com_jssupportticket&c=postinstallation&layout=stepone');
	}

	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		// $parent is the class calling this method
		echo '<p>' . JText::_('Thank you to using JS Support Ticket') . '</p>';
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		// $parent is the class calling this method
		
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		
		jimport('joomla.installer.helper');
		$installer = new JInstaller();
		$user = JFactory::getUser();
		$email = $user->email;
		$created = date('Y-m-d H:i:s');
		$db = JFactory::getDbo();
		
		$query = "SELECT COUNT(id) FROM `#__js_ticket_email`;";
		$db->setQuery($query);
		$emails = $db->loadResult();

		if($emails == 0){
			$query = "INSERT INTO `#__js_ticket_email`(autoresponce,priorityid,email,status,created) VALUES (1,1,\"".$email."\",1,'".$created."');";
			
			$db->setQuery($query);
			$db->execute();
		}		
		$ext_plugin_path = JPATH_ADMINISTRATOR.'/components/com_jssupportticket/extensions/plugins/';		
		$extensions = array(
			'jssupportticketicon.zip'=>'JS Support Ticket icon'
		);

		echo "<br /><br /><font color='green'><strong>Installing Plugins</strong></font>";
		foreach( $extensions as $ext => $extname ){
			$package = JInstallerHelper::unpack( $ext_plugin_path.$ext );
			if( $installer->install( $package['dir'] ) ){
				echo "<br /><font color='green'>$extname successfully installed.</font>";
			}else{
				echo "<br /><font color='red'>ERROR: Could not install the $extname. Please install manually.</font>";
			}
			JInstallerHelper::cleanupInstall( $ext_plugin_path.$ext, $package['dir'] ); 
		}
		
		$update_sql_path = JPATH_ADMINISTRATOR.'/components/com_jssupportticket/sql/updates/mysql/';
		$sql_files = glob($update_sql_path.'/*');  
   
		// Deleting all the files in the list 
		foreach($sql_files as $file) { 
			if(is_file($file)){  
				// Delete the given file 
				unlink($file); 
			}				
		} 
		
	}

}
