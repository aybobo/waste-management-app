
    <link rel="stylesheet" href="<?=base_url()?>assets/css/parsley.css">
    <!-- my custom css -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/style.css">
</head>

<body>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    <!-- /Preloader -->
	
	<!-- HK Wrapper -->
	<div class="hk-wrapper hk-vertical-nav">

        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-xl navbar-light fixed-top hk-navbar">
            <a id="navbar_toggle_btn" class="navbar-toggle-btn nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="menu"></i></span></a>
            <a class="navbar-brand" href="<?=site_url('home/index')?>">
                <img class="brand-img d-inline-block" src="<?=base_url()?>dist/img/logo-light.png" alt="brand" />
            </a>
            <ul class="navbar-nav hk-navbar-content">
                <!--<li class="nav-item">
                    <a id="navbar_search_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="search"></i></span></a>
                </li>
                <li class="nav-item">
                    <a id="settings_toggle_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="settings"></i></span></a>
                </li>
                <li class="nav-item dropdown dropdown-notifications">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="feather-icon"><i data-feather="bell"></i></span><span class="badge-wrap"><span class="badge badge-brown badge-indicator badge-indicator-sm badge-pill pulse"></span></span></a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <h6 class="dropdown-header">Notifications <a href="javascript:void(0);" class="">View all</a></h6>
                        <div class="notifications-nicescroll-bar">
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <img src="dist/img/avatar1.jpg" alt="user" class="avatar-img rounded-circle">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text"><span class="text-dark text-capitalize">Evie Ono</span> accepted your invitation to join the team</div>
                                            <div class="notifications-time">12m</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <img src="dist/img/avatar2.jpg" alt="user" class="avatar-img rounded-circle">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">New message received from <span class="text-dark text-capitalize">Misuko Heid</span></div>
                                            <div class="notifications-time">1h</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-primary rounded-circle">
													<span class="initial-wrap"><span><i class="zmdi zmdi-account font-18"></i></span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">You have a follow up with<span class="text-dark text-capitalize"> Brunette head</span> on <span class="text-dark text-capitalize">friday, dec 19</span> at <span class="text-dark">10.00 am</span></div>
                                            <div class="notifications-time">2d</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-success rounded-circle">
													<span class="initial-wrap"><span>A</span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Application of <span class="text-dark text-capitalize">Sarah Williams</span> is waiting for your approval</div>
                                            <div class="notifications-time">1w</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-warning rounded-circle">
													<span class="initial-wrap"><span><i class="zmdi zmdi-notifications font-18"></i></span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Last 2 days left for the project</div>
                                            <div class="notifications-time">15d</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>-->
                <li class="nav-item dropdown dropdown-authentication">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media">
                            <!--<div class="media-img-wrap">
                                <div class="avatar">
                                    <img src="dist/img/avatar12.jpg" alt="user" class="avatar-img rounded-circle">
                                </div>
                                <span class="badge badge-success badge-indicator"></span>
                            </div>-->
                            <div class="media-body">
                                <span>Hi <?php echo $this->session->userdata('username'); ?>!<i class="zmdi zmdi-chevron-down"></i></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                        <!--<a class="dropdown-item" href="profile.html"><i class="dropdown-icon zmdi zmdi-account"></i><span>Profile</span></a>
                        <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-card"></i><span>My balance</span></a>
                        <a class="dropdown-item" href="inbox.html"><i class="dropdown-icon zmdi zmdi-email"></i><span>Inbox</span></a>-->
                        <a class="dropdown-item" href="<?=site_url('home/changepassword')?>"><i class="dropdown-icon zmdi zmdi-settings"></i><span>Change Password</span></a>
                        <!--<div class="dropdown-divider"></div>
                        <div class="sub-dropdown-menu show-on-hover">
                            <a href="#" class="dropdown-toggle dropdown-item no-caret"><i class="zmdi zmdi-check text-success"></i>Online</a>
                            <div class="dropdown-menu open-left-side">
                                <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-check text-success"></i><span>Online</span></a>
                                <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-circle-o text-warning"></i><span>Busy</span></a>
                                <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-minus-circle-outline text-danger"></i><span>Offline</span></a>
                            </div>
                        </div>-->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=site_url('admin/logout')?>"><i class="dropdown-icon zmdi zmdi-power"></i><span>Log out</span></a>
                    </div>
                </li>
            </ul>
        </nav>
        <!--<form role="search" class="navbar-search">
            <div class="position-relative">
                <a href="javascript:void(0);" class="navbar-search-icon"><span class="feather-icon"><i data-feather="search"></i></span></a>
                <input type="text" name="example-input1-group2" class="form-control" placeholder="Type here to Search">
                <a id="navbar_search_close" class="navbar-search-close" href="#"><span class="feather-icon"><i data-feather="x"></i></span></a>
            </div>
        </form>-->
        <!-- /Top Navbar -->

        <!-- Vertical Nav -->
        <nav class="hk-nav hk-nav-light">
            <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
            <div class="nicescroll-bar">
                <div class="navbar-nav-wrap">
                    <!--<ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#" >
                                <span class="feather-icon"><i data-feather="user"></i></span>
                                <span class="nav-link-text">User Accounts</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-with-badge" href="#">
                                <span class="feather-icon"><i data-feather="eye"></i></span>
                                <span class="nav-link-text">Changelog</span>
                                <span class="badge badge-sm badge-success badge-pill">v 1.0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="feather-icon"><i data-feather="headphones"></i></span>
                                <span class="nav-link-text">Support</span>
                            </a>
                        </li>
                    </ul>-->
                    <ul class="navbar-nav flex-column">
                        <!--<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#dash_drp">
                                <span class="feather-icon"><i data-feather="activity"></i></span>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                            <ul id="dash_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/sectorhome')?>">YO</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="dashboard2.html">Project</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="dashboard3.html">Statistics</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="dashboard4.html">Classic</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="dashboard5.html">Analytics</a>
                                        </li>
									</ul>
                                </li>
                            </ul>
                        </li>-->
                        <!--<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#app_drp">
                                <span class="feather-icon"><i data-feather="package"></i></span>
                                <span class="nav-link-text">Application</span>
                                <span class="badge badge-brown badge-pill">4</span>
                            </a>
                            <ul id="app_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="chats.html">Chat</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="calendar.html">Calendar</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="email.html">Email</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="file-manager.html">File Manager</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>-->
                        <!--<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#auth_drp">
                                <span class="feather-icon"><i data-feather="zap"></i></span>
                                <span class="nav-link-text">Customer Accounts</span>
                            </a>
                            <ul id="auth_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#signup_drp">
													Sign Up
												</a>
                                            <ul id="signup_drp" class="nav flex-column collapse collapse-level-2">
                                                <li class="nav-item">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="signup.html">Cover</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="signup-simple.html">Simple</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#signin_drp">
													Login
												</a>
                                            <ul id="signin_drp" class="nav flex-column collapse collapse-level-2">
                                                <li class="nav-item">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="login.html">Cover</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="login-simple.html">Simple</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#recover_drp">
													Recover Password
												</a>
                                            <ul id="recover_drp" class="nav flex-column collapse collapse-level-2">
                                                <li class="nav-item">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="forgot-password.html">Forgot Password</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="reset-password.html">Reset Password</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="lock-screen.html">Lock Screen</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="404.html">Error 404</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="maintenance.html">Maintenance</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drp">
                                <span class="feather-icon"><i data-feather="user"></i></span>
                                <span class="nav-link-text">User Accounts</span>
                            </a>
                            <ul id="tables_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('users/userhome')?>">Create User</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('users/viewusers')?>">View User</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- sector -->
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drp1">
                                <span class="feather-icon"><i data-feather="home"></i></span>
                                <span class="nav-link-text">Sector Setup</span>
                            </a>
                            <ul id="tables_drp1" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/sectorhome')?>">Create Sector</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/viewsectors')?>">View Sector</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- sector area -->

                        <!-- sector -->
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drp1x">
                                <span class="feather-icon"><i data-feather="home"></i></span>
                                <span class="nav-link-text">Sector Area Setup</span>
                            </a>
                            <ul id="tables_drp1x" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/areahome')?>">Create Sector Area</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/viewareas')?>">View Sector Area</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- commercial type -->

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drp1y">
                                <span class="feather-icon"><i data-feather="home"></i></span>
                                <span class="nav-link-text">Commercial Types</span>
                            </a>
                            <ul id="tables_drp1y" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/commercialhome')?>">Create Commercial Type</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/viewcommercialtypes')?>">View Commercial Type</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- street -->

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drp2">
                                <span class="feather-icon"><i data-feather="home"></i></span>
                                <span class="nav-link-text">Street Setup</span>
                            </a>
                            <ul id="tables_drp2" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/streethome')?>">Create Street</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/viewstreets')?>">View Street</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- house -->

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drp3">
                                <span class="feather-icon"><i data-feather="home"></i></span>
                                <span class="nav-link-text">House Setup</span>
                            </a>
                            <ul id="tables_drp3" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/househome')?>">Create House</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/viewhouses')?>">View House</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- house category -->

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drp4">
                                <span class="feather-icon"><i data-feather="home"></i></span>
                                <span class="nav-link-text">House Category</span>
                            </a>
                            <ul id="tables_drp4" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/categoryhome')?>">Create House Category</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/viewcategories')?>">View House Categories</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- agent -->

                        <!--<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drp5">
                                <span class="feather-icon"><i data-feather="user"></i></span>
                                <span class="nav-link-text">Agent Setup</span>
                            </a>
                            <ul id="tables_drp5" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/agenthome')?>">Add Agent</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/viewagents')?>">View Agents</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>-->

                        <!-- customer setup -->

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drp6">
                                <span class="feather-icon"><i data-feather="user"></i></span>
                                <span class="nav-link-text">Customer Setup</span>
                            </a>
                            <ul id="tables_drp6" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/customerhome')?>">Add Customer</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/viewcustomers')?>">View Customers</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- payments -->

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drpa">
                                <span class="feather-icon"><i data-feather="plus"></i></span>
                                <span class="nav-link-text">Payments</span>
                            </a>
                            <ul id="tables_drpa" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/addpayment')?>">Add Payment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/addpaymentbycode')?>">Add Payment(Customer Code)</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="#">Part Payment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Past Payment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Combine Payment</a>
                                        </li>-->
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="#">View Payments</a>
                                        </li>-->
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- invoice -->

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drpp">
                                <span class="feather-icon"><i data-feather="plus"></i></span>
                                <span class="nav-link-text">Invoice</span>
                            </a>
                            <ul id="tables_drpp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/invoicepage')?>">General Invoice</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/addinvoicebycode')?>">Generate Invoice(Customer Code)</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="#">Part Payment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Past Payment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Combine Payment</a>
                                        </li>-->
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="#">View Payments</a>
                                        </li>-->
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                    <!--<ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Customer Records</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-with-badge" href="#">
                                <span class="feather-icon"><i data-feather="eye"></i></span>
                                <span class="nav-link-text">Changelog</span>
                                <span class="badge badge-sm badge-success badge-pill">v 1.0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="feather-icon"><i data-feather="headphones"></i></span>
                                <span class="nav-link-text">Support</span>
                            </a>
                        </li>
                    </ul>-->
                    <!--<hr class="nav-separator">
                    <div class="nav-header">
                        <span>User Interface</span>
                        <span>UI</span>
                    </div>-->
                    <ul class="navbar-nav flex-column">
                        <!--<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#Components_drp">
                                <span class="feather-icon"><i data-feather="layout"></i></span>
                                <span class="nav-link-text">Payments</span>
                            </a>
                            <ul id="Components_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="alerts.html">Alerts</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="avatar.html">Avatar</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="badge.html">Badge</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="buttons.html">Buttons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="cards.html">Cards</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="carousel.html">Carousel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="collapse.html">Collapse</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="dropdowns.html">Dropdown</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="list-group.html">List Group</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="modal.html">Modal</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="nav.html">Nav</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="navbar.html">Navbar</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="nestable.html">Nestable</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pagination.html">Pagination</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="popovers.html">Popovers</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="progress.html">Progress</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="tooltip.html">Tooltip</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>-->
                        <!--<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#content_drp">
                                <span class="feather-icon"><i data-feather="type"></i></span>
                                <span class="nav-link-text">Content</span>
                            </a>
                            <ul id="content_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="typography.html">Typography</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="images.html">Images</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="media-object.html">Media Object</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#utilities_drp">
                                <span class="feather-icon"><i data-feather="anchor"></i></span>
                                <span class="nav-link-text">Reports</span>
                            </a>
                            <ul id="utilities_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('reports/paymentsrecord')?>">Payments</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('reports/debtorspage')?>">Debtors</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('customersetup/debtanalysis')?>">Debt Analysis</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('reports/commissions')?>">Commissions</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('reports/customerrecords')?>">Customer Records</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('reports/cashbook')?>">Cash Book</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="shadow.html">Shadow</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="sizing.html">Sizing</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="spacing.html">Spacing</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#forms_drp">
                                <span class="feather-icon"><i data-feather="server"></i></span>
                                <span class="nav-link-text">Assets Setup</span>
                            </a>
                            <ul id="forms_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('assets/assetcategory')?>">Create Asset Category</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('assets/viewassetcategory')?>">View Asset Category</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('assets/assetindex')?>">Create Asset</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('assets/viewassets')?>">View Asset</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="form-mask.html">Form Mask</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="form-validation.html">Form Validation</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="form-wizard.html">Form Wizard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="file-upload.html">File Upload</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editor.html">Editor</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- liablities -->

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#forms_drpss">
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Liabilities Setup</span>
                            </a>
                            <ul id="forms_drpss" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('assets/addliability')?>">Add Liability</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('assets/viewliabilities')?>">View Liabilities</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="form-mask.html">Form Mask</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="form-validation.html">Form Validation</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="form-wizard.html">Form Wizard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="file-upload.html">File Upload</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editor.html">Editor</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#tables_drp7">
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Expenses</span>
                            </a>
                            <ul id="tables_drp7" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('assets/expensehome')?>">Add Expense</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=site_url('assets/viewexpense')?>">View Expense</a>
                                        </li>
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="responsive-table.html">Responsive Table</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="editable-table.html">Editable Table</a>
                                        </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#charts_drp">
                                <span class="feather-icon"><i data-feather="pie-chart"></i></span>
                                <span class="nav-link-text">Charts</span>
                            </a>
                            <ul id="charts_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="line-charts.html">Line Chart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="area-charts.html">Area Chart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="bar-charts.html">Bar Chart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pie-charts.html">Pie Chart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="realtime-charts.html">Realtime Chart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="mini-charts.html">Mini Chart</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>-->
                        <!--<li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#maps_drp">
                                <span class="feather-icon"><i data-feather="map"></i></span>
                                <span class="nav-link-text">Maps</span>
                            </a>
                            <ul id="maps_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="google-map.html">Google Map</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="vector-map.html">Vector Map</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>-->
                    </ul>
                    <!--<hr class="nav-separator">
                    <div class="nav-header">
                        <span>Getting Started</span>
                        <span>GS</span>
                    </div>-->
                    <!--<ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="documentation.html" >
                                <span class="feather-icon"><i data-feather="book"></i></span>
                                <span class="nav-link-text">Documentation</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-with-badge" href="#">
                                <span class="feather-icon"><i data-feather="eye"></i></span>
                                <span class="nav-link-text">Changelog</span>
                                <span class="badge badge-sm badge-success badge-pill">v 1.0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="feather-icon"><i data-feather="headphones"></i></span>
                                <span class="nav-link-text">Support</span>
                            </a>
                        </li>
                    </ul>-->
                </div>
            </div>
        </nav>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->

        <!-- Setting Panel -->
        <!--<div class="hk-settings-panel">
            <div class="nicescroll-bar position-relative">
                <div class="settings-panel-wrap">
                    <div class="settings-panel-head">
                        <img class="brand-img d-inline-block align-top" src="dist/img/logo-light.png" alt="brand" />
                        <a href="javascript:void(0);" id="settings_panel_close" class="settings-panel-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
                    </div>
                    <hr>
                    <h6 class="mb-5">Layout</h6>
                    <p class="font-14">Choose your preferred layout</p>
                    <div class="layout-img-wrap">
                        <div class="row">
                            <a href="javascript:void(0);" class="col-6 mb-30 active">
                                <img class="rounded opacity-70" src="dist/img/layout1.png" alt="layout">
                                <i class="zmdi zmdi-check"></i>
                            </a>
                            <a href="dashboard2.html" class="col-6 mb-30">
                                <img class="rounded opacity-70" src="dist/img/layout2.png" alt="layout">
                                <i class="zmdi zmdi-check"></i>
                            </a>
                           <a href="dashboard3.html" class="col-6 mb-30">
                                <img class="rounded opacity-70" src="dist/img/layout3.png" alt="layout">
                                <i class="zmdi zmdi-check"></i>
                            </a>
							<a href="dashboard4.html" class="col-6 mb-30">
                                <img class="rounded opacity-70" src="dist/img/layout4.png" alt="layout">
                                <i class="zmdi zmdi-check"></i>
                            </a>
							<a href="dashboard5.html" class="col-6">
                                <img class="rounded opacity-70" src="dist/img/layout5.png" alt="layout">
                                <i class="zmdi zmdi-check"></i>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <h6 class="mb-5">Navigation</h6>
                    <p class="font-14">Menu comes in two modes: dark & light</p>
                    <div class="button-list hk-nav-select mb-10">
                        <button type="button" id="nav_light_select" class="btn btn-outline-primary btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-sun-o"></i> </span><span class="btn-text">Light Mode</span></button>
                        <button type="button" id="nav_dark_select" class="btn btn-outline-light btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-moon-o"></i> </span><span class="btn-text">Dark Mode</span></button>
                    </div>
                    <hr>
                    <h6 class="mb-5">Top Nav</h6>
                    <p class="font-14">Choose your liked color mode</p>
                    <div class="button-list hk-navbar-select mb-10">
                        <button type="button" id="navtop_light_select" class="btn btn-outline-primary btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-sun-o"></i> </span><span class="btn-text">Light Mode</span></button>
                        <button type="button" id="navtop_dark_select" class="btn btn-outline-light btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-moon-o"></i> </span><span class="btn-text">Dark Mode</span></button>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Scrollable Header</h6>
                        <div class="toggle toggle-sm toggle-simple toggle-light toggle-bg-primary scroll-nav-switch"></div>
                    </div>
                    <button id="reset_settings" class="btn btn-primary btn-block btn-reset mt-30">Reset</button>
                </div>
            </div>
            <img class="d-none" src="dist/img/logo-light.png" alt="brand" />
            <img class="d-none" src="dist/img/logo-dark.png" alt="brand" />
        </div>-->
        <!-- /Setting Panel -->