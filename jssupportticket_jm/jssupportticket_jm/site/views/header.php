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

defined('_JEXEC') or die('Restricted access');

$id = JFactory::getApplication()->input->get('id');
$isguest=$this->user->getIsGuest();
$layout=$this->layoutname;
$commonpath="index.php?option=com_jssupportticket";
$obj=[];
$array[]=array('text'=> JText::_('Dashboard'));?>
<?php
     if ($layout != null) {
        switch ($layout) {
            /*Control Panel*/
            case 'controlpanel':
                $array[] = array('text' => JText::_('Dashboard'));
            break;
            /*Tickets*/
            case 'formticket':
                $text = ($id) ? JText::_('Edit Ticket') : JText::_('Add Ticket');
                $array[] = array('text' => $text);
                break;
            case 'mytickets':
                $array[] = array('text' => JText::_('My Tickets'));
                break;
            case 'ticketdetail':
                $array[] = array('text' => JText::_('Ticket Details'));
            break;
            case 'adderasedatarequest':
                $array[] = array('text' => JText::_('Erase Data Request'));
            break;
        }
    }
?>
<?php if (isset($array)) {
    foreach ($array AS $obj);
} ?>
<div id="jsst-header-main-wrapper">
    <div id="jsst-header">
        <div id="jsst-tabs-wrp" class="" >
                <span class="jsst-header-tab">
                    <a class="js-cp-menu-link <?php if($layout=='controlpanel') echo ' selected'; ?> " href="index.php?option=com_jssupportticket&c=jssupportticket&layout=controlpanel&Itemid=<?php echo $this->Itemid; ?>">
                        <?php echo JText::_('Dashboard'); ?>
                    </a>
                </span>
                <span class="jsst-header-tab">
                    <a class="js-cp-menu-link <?php if($layout=='formticket') echo ' selected'; ?> " href="index.php?option=com_jssupportticket&c=ticket&layout=formticket&Itemid=<?php echo $this->Itemid; ?>" >
                        <?php echo JText::_('Submit Ticket'); ?>
                    </a>
                </span>
                <span class="jsst-header-tab">
                    <?php
                        $link = "index.php?option=com_jssupportticket&c=ticket&layout=mytickets&Itemid=".$this->Itemid;
                    ?>
                    <a class="js-cp-menu-link" href="<?php echo $link; ?>">
                        <?php echo JText::_('My Tickets'); ?>
                    </a>
                </span>
            <?php  $redirect = JRoute::_("index.php?option=com_jssupportticket&c=jssupportticket&layout=controlpanel&Itemid=" . $this->Itemid , false);
            $redirect = '&amp$isguest=$this->user->getIsGuest();;return=' . base64_encode($redirect);
            if($isguest){ ?>
                <span class="jsst-header-tab jsst-header-tab-right">
                    <a class="js-cp-menu-link" href="<?php echo 'index.php?option=com_users&view=login' . $redirect; ?>">
                        <?php echo JText::_('Login'); ?>
                    </a>
                </span>
            <?php }else{
                $link = "index.php?option=com_jssupportticket&c=jssupportticket&task=logout&return=".$redirect."&Itemid=" . $this->Itemid; ?>
                <span class="jsst-header-tab jsst-header-tab-right">
                    <a class="js-cp-menu-link" href="<?php echo $link; ?>">
                        <?php echo JText::_('Log Out'); ?>
                    </a>
                </span>
            <?php } ?>
        </div>
    </div>
</div>

