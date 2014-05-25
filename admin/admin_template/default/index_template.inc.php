<!DOCTYPE html>
<html><head><title><?php echo $page_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0" />
<meta http-equiv="Expires" content="Sat, 26 Jul 1997 05:00:00 GMT" />

<link href="<?php echo $sysconf['admin_template']['css']; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo ATD; ?>css/sb-admin.css" rel="stylesheet">

<link href="<?php echo ATD; ?>css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
<link href="<?php echo ATD; ?>css/plugins/timeline/timeline.css" rel="stylesheet">

<link rel="icon" href="<?php echo SWB; ?>webicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo SWB; ?>webicon.ico" type="image/x-icon" />
<link href="<?php echo SWB; ?>template/core.style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo JWB; ?>chosen/chosen.css" rel="stylesheet" type="text/css" />
<link href="<?php echo JWB; ?>colorbox/colorbox.css" rel="stylesheet" type="text/css" />
<link href="<?php echo JWB; ?>jquery.imgareaselect/css/imgareaselect-default.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo JWB; ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>updater.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>gui.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>form.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>calendar.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>keyboard.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>chosen/ajax-chosen.min.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>tooltipsy.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>jquery.imgareaselect/scripts/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>webcam.js"></script>
<script type="text/javascript" src="<?php echo JWB; ?>scanner.js"></script>
<script type="text/javascript" src="<?php echo ATD; ?>js/plugins/jqueryCookie/jquery.cookie.js"></script>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <a class="navbar-brand" id="main-menu-toggle" href="#" onclick="navMin()"><i class="fa fa-bars"></i></a>
            <div class="navbar-inner">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./index.php">
                        <div id="logo"></div>
                        <?php echo $sysconf['library_name']; ?>
                    </a>
                    <!--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>
                    --><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar-colapse"><i class="navbar-icon fa fa-bars"></i></button>
                </div>
                
                <div class="collapse navbar-collapse" id="main-navbar-colapse">
                    <div>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <?php
                                    $username = $_SESSION['uname'];
                                    $img_q = $dbs->query("SELECT user_image FROM user WHERE username='$username'");
                                    $img_d = $img_q->fetch_row();
                                    ?>
                                    <img src="<?php echo '../images/persons/'.$img_d[0]; ?>" class="img-circle img-profile"/>&nbsp;
                                    <span><?php echo $_SESSION['realname']; ?></span>
                                    <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li class="sub_menu"><a href="<?php echo MWB.'system/app_user.php?changecurrent=true&action=detail'; ?>"><i class="fa fa-user fa-fw"></i> Profile</a>
                                    </li>
                                    <li><a href="index.php?mod=system"><i class="fa fa-gear fa-fw"></i> Settings</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="logout.php"><i class="fa fa-power-off fa-fw"></i> Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- /.navbar-static-top -->
        
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebarCollapse">
                <ul class="nav" id="side-menu">
                    <?php echo $main_menu; ?>
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->
        
        <div id="page-wrapper">
            <div class="row" id="mainContent">
                <?php echo $main_content; ?>
            </div>
        </div>
        
        <!-- license info -->
        <div id="footer" style="display: none"><?php echo $sysconf['page_footer']; ?></div>
        <!-- license info end --><!-- fake submit iframe for search form, DONT REMOVE THIS! -->
        <iframe name="blindSubmit" style="visibility: hidden; width: 0; height: 0;"></iframe>
        <!-- <iframe name="blindSubmit" style="visibility: visible; width: 100%; height: 300px;"></iframe> -->
        <!-- fake submit iframe -->
    </div>
    
    <!-- Core Scripts - Include with every page -->
    <script src="<?php echo ATD; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo ATD; ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="<?php echo ATD; ?>js/sb-admin.js"></script>

</body>
</html>