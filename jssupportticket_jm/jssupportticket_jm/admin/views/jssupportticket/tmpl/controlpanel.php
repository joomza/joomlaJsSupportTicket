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
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jssupportticket/include/css/circle.css');
$document->addScript('components/com_jssupportticket/include/js/circle.js');
?>

<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
<script>
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawStackChartHorizontal);
    google.setOnLoadCallback(drawTodayTicketsChart);
    function drawStackChartHorizontal() {
      var data = google.visualization.arrayToDataTable([
        <?php
            echo $this->result['stack_chart_horizontal']['title'].',';
            echo $this->result['stack_chart_horizontal']['data'];
        ?>
      ]);

      var view = new google.visualization.DataView(data);

      var options = {
        height:305,
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '75%' },
        isStacked: true,
        colors:<?php echo $this->result['stack_chart_horizontal']['colors']; ?>
      };
      var chart = new google.visualization.BarChart(document.getElementById("stack_chart_horizontal"));
      chart.draw(view, options);
    }
    function drawTodayTicketsChart() {
      var data = google.visualization.arrayToDataTable([
        <?php
            echo $this->result['today_ticket_chart']['title'].',';
            echo $this->result['today_ticket_chart']['data'];
        ?>
      ]);

      var view = new google.visualization.DataView(data);

      var options = {
        height:120,
        chartArea: { width: '70%', left: 30 },
        legend: { position: "right" },
        hAxis: { textPosition: 'none' },
        colors:<?php echo  $this->result['stack_chart_horizontal']['colors']; ?>,
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("today_ticket_chart"));
      chart.draw(view, options);
    }
</script>
<div id="js-tk-admin-wrapper">
    <div id="js-tk-leftmenu">
        <?php include_once('components/com_jssupportticket/views/menu.php'); ?>
    </div>
    <div id="js-tk-cparea">
        <div id="jsstadmin-wrapper-top">
            <div id="jsstadmin-wrapper-top-left">
                <div id="jsstadmin-breadcrunbs">
                    <ul>
                        <li>
                            <a href="index.php?option=com_jssupportticket&c=jssupportticket&layout=controlpanel" title="Dashboard">
                                <?php echo JText::_('Dashboard'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="jsstadmin-wrapper-top-right">
                <div id="jsstadmin-config-btn">
                    <a title="Configuration" href="index.php?option=com_jssupportticket&c=config&layout=config">
                        <img alt="Configuration" src="components/com_jssupportticket/include/images/config.png">
                    </a>
                </div>
                <div id="jsstadmin-vers-txt">
                    <?php echo JText::_('Version').JText::_(' : '); ?>
                    <span class="jsstadmin-ver">
                        <?php $version = str_split($this->version);
                        $version = implode('.', $version);
                        echo $version; ?>
                    </span>
                </div>
            </div>
        </div>
        <div id="js-tk-heading">
            <h1 class="jsstadmin-head-text">
                <?php echo JText::_('Dashboard'); ?>
            </h1>
            <a href="index.php?option=com_jssupportticket&c=ticket&layout=tickets" class="jsstadmin-add-link button" title="All Tickets">
                <img alt="All Tickets" src="components/com_jssupportticket/include/images/c_p/all-tickets.png">
                <?php echo JText::_('All Tickets'); ?>
            </a>
        </div>
        <?php
        $open_percentage = 0;
        $close_percentage = 0;
        $answered_percentage = 0;
        $close_percentage = 0;
        $allticket_percentage = 0;
        if($this->config['show_count_tickets'] == 1 && isset($this->result['ticket_total']['totalticket']) && $this->result['ticket_total']['totalticket'] != 0){
            $open_percentage  = round(($this->result['ticket_total']['openticket'] / $this->result['ticket_total']['totalticket']) * 100);
            // $close_percentage  = round(($this->result['ticket_total']['closeticket'] / $this->result['ticket_total']['totalticket']) * 100);
            $answered_percentage = round(($this->result['ticket_total']['answeredticket'] / $this->result['ticket_total']['totalticket']) * 100);
            $close_percentage = round(($this->result['ticket_total']['closeticket'] / $this->result['ticket_total']['totalticket']) * 100);
            $allticket_percentage = 100;
        }?>
        <div id="jsstadmin-data-wrp" class="js-bg-null js-padding-all-null">
            <div class="js-cp-cnt-sec">
                <div class="js-cp-cnt-left">
                    <div class="js-row js-ticket-top-cirlce-count-wrp js-ticket-admin-dashboard-top-cirlce-count-wrp">
                        <div class="js-col-xs-12 js-col-md-2 js-myticket-link js-ticket-myticket-link-myticket js-ticket-open">
                            <a class="js-ticket-green js-myticket-link" href="javascript:void(0);">
                                <div class="js-ticket-cricle-wrp ">
                                    <div class="circlebar" data-circle-startTime=0 data-circle-maxValue="<?php echo $open_percentage; ?>" data-circle-dialWidth=15 data-circle-size="100px" data-circle-type="progress">
                                        <div class="loader-bg"></div>
                                    </div>
                                </div>
                                <div class="js-ticket-circle-count-text">
                                    <?php
                                        echo JText::_('Open');
                                        if($this->config['show_count_tickets'] == 1)
                                        echo " ( " . $this->result['ticket_total']['openticket'] . " ) ";
                                    ?>
                                </div>
                            </a>
                        </div>
                        <div class="js-col-xs-12 js-col-md-2 js-myticket-link js-ticket-myticket-link-myticket js-ticket-close">
                            <a class="js-ticket-orange js-myticket-link" href="javascript:void(0);">
                                <div class="js-ticket-cricle-wrp">
                                    <div class="circlebar" data-circle-startTime=0 data-circle-maxValue="<?php echo $close_percentage; ?>" data-circle-dialWidth=15 data-circle-size="100px" data-circle-type="progress">
                                        <div class="loader-bg "></div>
                                    </div>
                                </div>
                                <div class="js-ticket-circle-count-text">
                                    <?php
                                        echo JText::_('Closed');
                                        if($this->config['show_count_tickets'] == 1)
                                        echo " ( ". $this->result['ticket_total']['closeticket'] . " ) ";
                                    ?>
                                </div>
                            </a>
                        </div>
                        <div class="js-col-xs-12 js-col-md-2 js-myticket-link js-ticket-myticket-link-myticket js-ticket-answer">
                            <a class="js-ticket-pink js-myticket-link" href="javascript:void(0);">
                                <div class="js-ticket-cricle-wrp">
                                    <div class="circlebar" data-circle-startTime = 0 data-circle-maxValue="<?php echo $answered_percentage; ?>" data-circle-dialWidth=15 data-circle-size="100px" data-circle-type="progress">
                                        <div class="loader-bg">
                                        </div>
                                    </div>
                                </div>
                                <div class="js-ticket-circle-count-text">
                                    <?php
                                        echo JText::_('Answered');
                                        if($this->config['show_count_tickets'] == 1)
                                        echo " ( ". $this->result['ticket_total']['answeredticket'] ." ) ";
                                    ?>
                                </div>
                            </a>
                        </div>
                        <div class="js-col-xs-12 js-col-md-2 js-myticket-link js-ticket-myticket-link-myticket js-ticket-allticket">
                            <a class="js-ticket-blue js-myticket-link" href="javascript:void(0);">
                                <div class="js-ticket-cricle-wrp">
                                    <div class="circlebar" data-circle-startTime=0 data-circle-maxValue="<?php echo $allticket_percentage; ?>" data-circle-dialWidth=15 data-circle-size="100px" data-circle-type="progress">
                                        <div class="loader-bg"></div>
                                    </div>
                                </div>
                                <div class="js-ticket-circle-count-text">
                                    <?php
                                        echo JText::_('All Tickets');
                                        if($this->config['show_count_tickets'] == 1)
                                        echo " ( " . $this->result['ticket_total']['totalticket'] . " ) ";
                                    ?>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- graph -->
                    <div class="js-cp-cnt">
                    <div id="graph-title">
                        <?php echo JText::_('Statistics'); ?>
                        <small>
                            <?php
                                $curdate = JHTML::_('date',date('Y-m-d'),"Y-m-d" );
                                $fromdate = JHTML::_('date',date('Y-m-d', strtotime("now -1 month")),"Y-m-d" );
                                echo " ($fromdate - $curdate)";
                            ?>
                        </small>
                    </div>
                    <div id="graph-area">
                        <div id="stack_chart_horizontal" style="width:100%;"></div>
                    </div>
                    </div>
                </div>
                <div class="js-cp-cnt-right">
                    <div class="js-cp-cnt">
                        <div class="js-cp-cnt-title">
                            <span class="js-cp-cnt-title-txt">
                                <?php echo JText::_('Today Tickets'); ?>
                            </span>
                        </div>
                        <div id="js-pm-grapharea">
                            <div id="today_ticket_chart" style="width:100%;"></div>
                        </div>
                    </div>
                    <div class="js-cp-cnt">
                        <div class="js-cp-cnt-title">
                            <span class="js-cp-cnt-title-txt">
                                <?php echo JText::_('Short Links'); ?>
                            </span>
                        </div>
                        <div id="js-wrapper-menus">
                            <a title="Tickets" class="js-mnu-area" href="index.php?option=com_jssupportticket&c=ticket&layout=tickets">
                                <div class="js-mnu-icon"><img src="components/com_jssupportticket/include/images/c_p/left-icons/tickets.png"/></div>
                                <div class="js-mnu-text"><span> <?php echo JText::_('Tickets'); ?></span></div>
                                <div class="js-mnu-arrowicon"><img src="components/com_jssupportticket/include/images/c_p/arrows/green.png"/></div>
                            </a>
                            <a title="Departments" class="js-mnu-area" href="index.php?option=com_jssupportticket&c=department&layout=departments">
                                <div class="js-mnu-icon"><img src="components/com_jssupportticket/include/images/c_p/left-icons/department.png"/></div>
                                <div class="js-mnu-text"><span> <?php echo JText::_('Departments'); ?></span></div>
                                <div class="js-mnu-arrowicon"><img src="components/com_jssupportticket/include/images/c_p/arrows/orange.png"/></div>
                            </a>
                            <a title="Priorities" class="js-mnu-area" href="index.php?option=com_jssupportticket&c=priority&layout=priorities">
                                <div class="js-mnu-icon"><img src="components/com_jssupportticket/include/images/c_p/left-icons/priorities.png"/></div>
                                <div class="js-mnu-text"><span> <?php echo JText::_('Priorities'); ?></span></div>
                                <div class="js-mnu-arrowicon"><img src="components/com_jssupportticket/include/images/c_p/arrows/light-blue.png"/></div>
                            </a>
                            <a title="Configurations" class="js-mnu-area" href="index.php?option=com_jssupportticket&c=config&layout=config">
                                <div class="js-mnu-icon"><img src="components/com_jssupportticket/include/images/c_p/left-icons/settings.png"/></div>
                                <div class="js-mnu-text"><span> <?php echo JText::_('Configurations'); ?></span></div>
                                <div class="js-mnu-arrowicon"><img src="components/com_jssupportticket/include/images/c_p/arrows/red.png"/></div>
                            </a>
                            <a title="Emails" class="js-mnu-area" href="index.php?option=com_jssupportticket&c=email&layout=emails">
                                <div class="js-mnu-icon"><img src="components/com_jssupportticket/include/images/c_p/left-icons/system-email.png"/></div>
                                <div class="js-mnu-text"><span> <?php echo JText::_('System Emails'); ?></span></div>
                                <div class="js-mnu-arrowicon"><img src="components/com_jssupportticket/include/images/c_p/arrows/green.png"/></div>
                            </a>
                            <a title="Email Templates" class="js-mnu-area" href="index.php?option=com_jssupportticket&c=emailtemplate&layout=emailtemplate&tf=ew-tk">
                                <div class="js-mnu-icon"><img src="components/com_jssupportticket/include/images/c_p/left-icons/email-templates.png"/></div>
                                <div class="js-mnu-text"><span> <?php echo JText::_('Email Templates'); ?></span></div>
                                <div class="js-mnu-arrowicon"><img src="components/com_jssupportticket/include/images/c_p/arrows/dark-blue.png"/></div>
                            </a>
                            <a title="Translations" class="js-mnu-area" href="index.php?option=com_jssupportticket&c=jssupportticket&layout=translation">
                                <div class="js-mnu-icon"><img src="components/com_jssupportticket/include/images/c_p/left-icons/translate.png"/></div>
                                <div class="js-mnu-text"><span> <?php echo JText::_('Translations'); ?></span></div>
                                <div class="js-mnu-arrowicon"><img src="components/com_jssupportticket/include/images/c_p/arrows/orange.png"/></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="js-cp-cnt-sec js-cp-baner">
                    <div class="js-cp-baner-cnt">
                        <div class="js-cp-banner-tit-bold">
                            <?php echo JText::_('Upgrade To Professional Version'); ?>
                        </div>
                        <div class="js-cp-banner-desc">
                            <?php echo JText::_('It has survived not only five centuries, but also the leap into electronic typesetting,remaining essentially unchanged.'); ?>
                        </div>
                        <div class="js-cp-banner-btn-wrp">
                            <a href="https://joomsky.com/products/js-support-ticket-pro-joomla.html" class="js-cp-banner-btn orange-bg">
                                <?php echo JText::_('Basic Package'); ?>
                            </a>
                            <a href="https://joomsky.com/products/js-support-ticket-pro-joomla.html" class="js-cp-banner-btn">
                                <?php echo JText::_('Professional Package'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <!-- latest tickets -->
            <?php if (!empty($this->result['tickets'])) { ?>
                <div class="js-cp-cnt-sec js-cp-tkt">
                <div class="js-mnu-sub-heading">
                    <span class="js-cp-cnt-title-txt"><?php echo JText::_("Latest Tickets"); ?>
                    </span>
                    <a href="index.php?option=com_jssupportticket&c=ticket&layout=tickets" class="js-cp-cnt-title-btn" title="View All Tickets">
                        <?php echo JText::_("View All Tickets"); ?>
                    </a>
                </div>
                <div class="js-ticket-admin-cp-tickets">
                    <?php foreach ($this->result['tickets'] AS $ticket): ?>
                        <div class="js-ticket-admin-cp-data">
                            <div class="js-cp-tkt-list-left">
                                <div class="js-cp-tkt-image">
                                    <img alt="" srcset="" src="<?php echo JURI::root(); ?>components/com_jssupportticket/include/images/user.png" class="avatar avatar-96 photo" height="96" width="96" />
                                </div>
                                <div class="js-cp-tkt-cnt">
                                    <div class="js-cp-tkt-info name">
                                        <span class="js-ticket-admin-cp-showhide" >
                                            <?php echo JText::_('From');
                                                    echo " : "; ?>
                                        </span>
                                        <?php echo $ticket->name; ?>
                                    </div>
                                    <div class="js-cp-tkt-info subject">
                                        <span class="js-ticket-admin-cp-showhide" >
                                            <?php echo JText::_('Subject');
                                                    echo " : "; ?>
                                        </span>
                                        <a title="Subject" href="">
                                            <?php echo $ticket->subject; ?>
                                        </a>
                                    </div>
                                    <div class="js-cp-tkt-info dept">
                                        <span class="js-cp-tkt-info-label">
                                            <?php echo JText::_('Department').' :'; ?>
                                            <?php if(isset($ticket->departmentname)) echo $ticket->departmentname; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="js-cp-tkt-status">
                                <span class="js-ticket-admin-cp-showhide" ><?php echo JText::_('Status');
                                                echo " : "; ?>
                                </span>
                                <?php
                                    if ($ticket->status == 0) {
                                        $style = "#1572e8;";
                                        $status = JText::_('New');
                                    }
                                    elseif ($ticket->status == 1) {
                                        $style = "orange;";
                                        $status = JText::_('Waiting Staff Reply');
                                    }
                                    elseif ($ticket->status == 2) {
                                        $style = "#FF7F50;";
                                        $status = JText::_('In progress');
                                    }
                                    elseif ($ticket->status == 3) {
                                        $style = "green;";
                                        $status = JText::_('Waiting your reply');
                                    }
                                    elseif ($ticket->status == 4) {
                                        $style = "blue;";
                                        $status = JText::_('Closed');
                                    }
                                    echo '<span style="color:' . $style . '">' . $status . '</span>';
                                ?>
                            </div>
                            <div class="js-cp-tkt-crted">
                                <span class="js-ticket-admin-cp-showhide" >
                                    <?php echo JText::_('Created');
                                    echo " : "; ?>
                                </span> <?php echo JHtml::_('date',$ticket->created,$this->config['date_format']); ?>
                            </div>
                            <div class="js-cp-tkt-prorty">
                                <span class="js-ticket-admin-cp-showhide" ><?php echo JText::_('Priority');
                                    echo " : "; ?>
                                </span>
                                <span style="background-color:<?php echo $ticket->prioritycolour; ?>;">
                                    <?php echo JText::_($ticket->priority); ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php } ?>
                <!-- Latest Downloads start -->
                <div class="js-cp-fed-ad-wrp">
                    <div class="js-cp-addon-wrp first-child">
                        <div class="js-cp-cnt-title">
                            <span class="js-cp-cnt-title-txt">
                                <?php echo JText::_("Latest Departments"); ?>
                            </span>
                        </div>
                        <?php if($this->latestdepartments && !empty($this->latestdepartments)){ ?>
                            <div class="js-cp-addon-list">
                                <?php foreach($this->latestdepartments AS $latestdepartments){ ?>
                                    <div class="js-cp-addon">
                                        <div class="js-cp-addon-cnt">
                                            <div class="js-cp-addon-tit">
                                                <?php echo $latestdepartments->departmentname; ?>
                                            </div>
                                            <div class="js-cp-addon-desc">
                                                    <?php echo $latestdepartments->departmentsignature; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="js-cp-addon-footer">
                                    <div class="js-cp-addon-cnt-footer"><a href="index.php?option=com_jssupportticket&c=department&layout=departments"><?php echo JText::_("Show All"); ?></a>

                                    </div>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div class="js-cp-addon-empty-data">
                                <div class="js-empty-data-upper-portion">
                                    <img src="components/com_jssupportticket/include/images/c_p/no-record.png" alt="">
                                </div>
                                <div class="js-empty-data-lower-portion">
                                    <?php echo JText::_("No Data"); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="js-cp-addon-wrp">
                        <div class="js-cp-cnt-title">
                            <span class="js-cp-cnt-title-txt">
                                <?php echo JText::_("Pro Version Features"); ?>
                            </span>
                        </div>
                        <div class="js-cp-addon-feature-data">
                            <div class="js-cp-addon">
                                <div class="js-cp-addon-tit">
                                    <?php echo JText::_("Big Collection Of Add-Ons"); ?>
                                </div>
                                <div class="js-cp-addon-desc">
                                        <?php echo JText::_("It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged."); ?>
                                </div>
                            </div>
                            <div class="js-empty-data-upper-portion">
                                <a href="index.php?option=com_jssupportticket&c=jssupportticket&layout=proversion">
                                    <img src="components/com_jssupportticket/include/images/c_p/pro-feature.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ticket History End -->
                <div id="jsreview-banner">
                    <div class="review">
                        <div class="upper">
                            <span class="simple-text">
                                <?php echo JText::_("We'd love to hear from you.<br>Please write an appreciated review at"); ?>
                            </span>
                            <a class="review-link" href="https://extensions.joomla.org/extension/js-support-ticket/" target="_blank" title="WP Extension Directory">
                                <img alt="star" src="components/com_jssupportticket/include/images/c_p/star.png"><?php echo JText::_("Joomla Extension Directory"); ?>
                            </a>
                        </div>
                        <div class="lower">
                            <span class="simple-text"><?php echo JText::_("Spread the word"); ?>:&nbsp;</span>
                            <a class="rev-soc-link" href="https://www.facebook.com/joomsky">
                                <img alt="fb" src="components/com_jssupportticket/include/images/c_p/fb.png">
                            </a>
                            <a class="rev-soc-link" href="https://twitter.com/joomsky">
                                <img alt="twitter" src="components/com_jssupportticket/include/images/c_p/twitter.png">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div id="js-tk-copyright">
    <img width="85" src="https://www.joomsky.com/logo/jssupportticket_logo_small.png">&nbsp;Powered by <a target="_blank" href="https://www.joomsky.com">Joom Sky</a><br/>
    &copy;Copyright 2008 - <?php echo date('Y'); ?>, <a target="_blank" href="https://www.burujsolutions.com">Buruj Solutions</a>
</div>
