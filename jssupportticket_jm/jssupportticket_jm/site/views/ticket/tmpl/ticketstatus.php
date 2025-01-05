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
?>
<div class="js-row js-null-margin">
<?php
JHTML::_('behavior.formvalidator');
if($this->config['offline'] != '1'){
    require_once JPATH_COMPONENT_SITE . '/views/header.php';
    $document = JFactory::getDocument();
    $document->addStyleSheet(JURI::root().'components/com_jssupportticket/include/css/inc.css/ticket-ticketstatus.css', 'text/css');
    $language = JFactory::getLanguage();
    $document->addStyleSheet(JURI::root().'components/com_jssupportticket/include/css/jssupportticketresponsive.css');
    if($language->isRTL()){
        $document->addStyleSheet(JURI::root().'components/com_jssupportticket/include/css/jssupportticketdefaultrtl.css');
    } ?> 

    <script language="javascript">
        function myValidate(f) {
            if (document.formvalidator.isValid(f)) {
                f.check.value='<?php if((JVERSION == '1.5') || (JVERSION == '2.5')) echo JUtility::getToken(); else echo  JSession::getFormToken(); ?>';
            }else{
                alert("<?php echo JText::_('Some values are not acceptable please retry');?>");
    			return false;
            }
    		return true;
        }
    </script>
    <div id="jsst-wrapper-top">
        <?php if($this->config['cur_location'] == 1){ ?>
            <div id="jsst-wrapper-top-left">
                <div id="jsst-breadcrunbs">
                    <ul>
                        <li>
                            <a href="index.php?option=com_jssupportticket&c=jssupportticket&layout=controlpanel&Itemid=<?php echo $this->Itemid; ?>" title="Dashboard">
                                <?php echo JText::_('Dashboard'); ?>
                            </a>
                        </li>
                        <li>
                            <?php echo JText::_('Ticket Status'); ?>
                        </li>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="js-ticket-checkstatus-wrp">
        <form class="js-ticket-form" action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data"  onSubmit="return myValidate(this);">
            <div class="js-ticket-checkstatus-field-wrp">
                <div class="js-ticket-field-title">
                    <label for="email">
                        <?php echo JText::_('Email'); ?>&nbsp;<font color="red">*</font>
                    </label>
                </div>
                <div class="js-ticket-field-wrp">
                    <input class="inputbox js-ticket-form-input-field required validate-email" type="text" name="email" id="email" size="40" maxlength="255" value="<?php if(isset($this->email)) echo $this->email; ?>"/>
                </div>
            </div>
            <div class="js-ticket-checkstatus-field-wrp">
                <div class="js-ticket-field-title">
                    <label for="ticketid"><?php echo JText::_('Ticket ID'); ?>&nbsp;<font color="red">*</font></label>
                </div>
                <div class="js-ticket-field-wrp">
                    <input class="inputbox js-ticket-form-input-field required" type="text" name="ticketid" id="ticketid" size="40" maxlength="255" value=""/>
                </div>
            </div>
            <div class="js-ticket-form-btn-wrp">
                <input type="submit" class="js-ticket-save-button" name="submit_app" value="<?php echo JText::_('Check Status'); ?>" />
            </div>
            <input type="hidden" name="view" value="ticket" />
            <input type="hidden" name="c" value="ticket" />
            <input type="hidden" name="layout" value="ticketdetail" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="check" value="" />
            <input type="hidden" name="checkstatus" value="1" />
            <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
            <input type="hidden" name="Itemid" value="<?php echo $this->Itemid; ?>" />
        </form>
    </div>
<?php
}else{
    messageslayout::getSystemOffline($this->config['title'],$this->config['offline_text']); //offline
}//End ?>
</div>
