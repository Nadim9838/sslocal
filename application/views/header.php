<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Social Media Automation</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>assets/header/css/bootstrap.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="<?php echo base_url(); ?>assets/header/css/plugins/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/header/css/plugins/dataTables.tableTools.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/header/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>assets/header/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>assets/header/css/daterangepicker-bs3.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/header/css/blueimp-gallery.min.css">
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/header/js/jquery-1.11.0.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/header/js/moment.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/header/js/daterangepicker.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/morris/raphael.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/morris/morris.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/morris/morris-data.js"></script>

    <!-- Custom JavaScript -->
    
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/dataTables/jquery-2.1.4.min.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/header/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/header/js/moment.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/header/js/daterangepicker.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/metisMenu/metisMenu.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/dataTables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/dataTables/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/dataTables/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/dataTables/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/dataTables/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/dataTables/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/header/js/plugins/dataTables/buttons.html5.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/header/js/jquery.blockUI.js"></script>
    <script src="<?php echo base_url(); ?>assets/header/js/jquery.confirm.js"></script>
    <script src="<?php echo base_url(); ?>assets/header/js/sb-admin-2.js"></script>

</head>

<body>

    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>home/dashboard">Social Media Automation</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fa fa-bell fa-fw icon-animated-bell"></i>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts" style="width:360px;">
                        <li id="appDetails"></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">

                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php base_url(); ?>logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn" type="button" style="margin-top: 0; margin-left: 8px; width:50px; height: 35px; padding: 0 0 3px 0;">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </li>
                        <?php 
                            $userPermissions = $this->session->userdata('permissions');
                            if (has_permission($userPermissions, 'dashboard', 'view')) { 
                        ?>
                            <li>
                                <a class="active" href="<?php echo base_url(); ?>home/dashboard" id="dashboard"><i class="fa fa-tachometer fa-fw"></i>&nbsp;Dashboard</a>
                            </li>
                        <?php } if (has_permission($userPermissions, 'user_management', 'view')) { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>home/user_management" id="user_management"><i class="fa fa-user fa-fw"></i>&nbsp; User Management</a>
                            </li>
                        <?php } if (has_permission($userPermissions, 'mobile_management', 'view')) { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>home/mobile_management" id="mobile_management"><i class="fa fa-mobile fa-fw"></i>&nbsp; Mobile Management</a>
                            </li>
                        <?php } if (has_permission($userPermissions, 'facebook_management', 'view')) { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>home/facebook_management" id="facebook_management"><i class="fa fa-facebook fa-fw"></i>&nbsp; Facebook Management</a>
                            </li>
                        <?php } if (has_permission($userPermissions, 'insta_management', 'view')) { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>home/insta_management" id="insta_management"><i class="fa fa-instagram fa-fw"></i>&nbsp; Instagram Management</a>
                            </li>
                        <?php } if (has_permission($userPermissions, 'twitter_management', 'view')) { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>home/twitter_management" id="twitter_management"><i class="fa fa-twitter fa-fw"></i>&nbsp; Twitter Management</a>
                            </li>
                        <?php } if (has_permission($userPermissions, 'youtube_management', 'view')) { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>home/youtube_management" id="youtube_management"><i class="fa fa-youtube fa-fw"></i>&nbsp; Youtube Management</a>
                            </li>
                        <?php } if (has_permission($userPermissions, 'tiktok_management', 'view')) { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>home/tiktok_management" id="tiktok_management"><i class="fa fa-music fa-fw"></i>&nbsp; Tik Tok Management</a>
                            </li>
                        <?php } if (has_permission($userPermissions, 'whatsapp_management', 'view')) { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>home/whatsapp_management" id="whatsapp_management"><i class="fa fa-comments fa-fw"></i>&nbsp; WhatsApp Management</a>
                            </li>
                        <?php } if (has_permission($userPermissions, 'report', 'view')) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>home/report" id="report"><i class="fa fa-file fa-fw"></i>&nbsp;Report</a>
                        </li>
                        <?php } if (has_permission($userPermissions, 'settings', 'view')) { ?>
                        <li>
                            <a href="<?php echo base_url(); ?>home/settings" id="settings"><i class="fa fa-gear fa-fw"></i>&nbsp;Settings</a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>