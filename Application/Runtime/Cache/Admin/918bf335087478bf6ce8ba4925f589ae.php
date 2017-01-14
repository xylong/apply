<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Empty Page</title>

    <link href="/apply/Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="/apply/Public/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/apply/Public/css/animate.css" rel="stylesheet">
    <link href="/apply/Public/css/style.css" rel="stylesheet">
</head>

<body class="">

    <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="/apply/Public/img/profile_small.jpg" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="mailbox.html">Mailbox</a></li>
                            <li class="divider"></li>
                            <li><a href="login.html">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li>
                    <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">系统设置</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?php echo U('Index/index');?>">菜单管理</a></li>
                        <li><a href="dashboard_2.html">Dashboard v.2</a></li>
                    </ul>
                </li>
                <li>
                    <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">用户管理</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?php echo U('User/index');?>">用户列表</a></li>
                        <li><a href="dashboard_2.html">Dashboard v.2</a></li>
                    </ul>
                </li>
                <li>
                    <a href="layouts.html"><i class="fa fa-diamond"></i> <span class="nav-label">Layouts</span></a>
                </li>
                <li>
                    <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">Apply </span><span class="label label-warning pull-right">16/24</span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?php echo U('Apply/borrow');?>">one</a></li>
                        <li><a href="<?php echo U('Apply/house');?>">two</a></li>
                        <li><a href="<?php echo U('Apply/square');?>">three</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="/apply/Public/img/a7.jpg">
                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="/apply/Public/img/a4.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="/apply/Public/img/profile.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>


                <li>
                    <a href="login.html">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>This is main title</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">This is</a>
                        </li>
                        <li class="active">
                            <strong>Breadcrumb</strong>
                        </li>
                    </ol>
                </div>
            </div>
<link href="/apply/Public/css/plugins/slick/slick.css" rel="stylesheet">
<link href="/apply/Public/css/plugins/slick/slick-theme.css" rel="stylesheet">


<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-7">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small pull-right">Last modification: <i class="fa fa-clock-o"></i> 2:10 pm - 12.06.2014</span>
                    <h2>Clients</h2>
                    <p>
                        All clients need to be verified before you can send email and set a project.
                    </p>
                    <div class="input-group">
                        <input type="text" placeholder="Search client " class="input form-control">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Search</button>
                        </span>
                    </div>
                    <div class="clients-list">
                    <ul class="nav nav-tabs">
                        <span class="pull-right small text-muted">1406 Elements</span>
                        <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Contacts</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-briefcase"></i> Companies</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                        <tr>
                                            <td class="client-avatar"><img alt="image" src="/apply/Public/img/a2.jpg"> </td>
                                            <td><a data-toggle="tab" href="#contact-1" class="client-link">Anthony Jackson</a></td>
                                            <td> Tellus Institute</td>
                                            <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                            <td> gravida@rbisit.com</td>
                                            <td class="text-right">
                                            	<button class="btn btn-info btn-xs"> Tag</button>
		                                        <button class="btn btn-danger btn-xs">&nbsp;<i class="fa fa-times"></i>&nbsp;</button>
                                        	</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="full-height-scroll">
                  				<div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                        <tr>
                                            <td class="client-avatar"><img alt="image" src="/apply/Public/img/a2.jpg"> </td>
                                            <td><a data-toggle="tab" href="#contact-1" class="client-link">Anthony Jackson</a></td>
                                            <td> Tellus Institute</td>
                                            <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                            <td> gravida@rbisit.com</td>
                                            <td class="text-right">
                                            	<button class="btn btn-info btn-xs"> Tag</button>
		                                        <button class="btn btn-danger btn-xs"> Mag</button>
                                        	</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="ibox ">

                <div class="ibox-content">
                    <div class="tab-content">
                        <div id="contact-1" class="tab-pane active">
                            <div class="row m-b-lg">
                                <div class="col-lg-4 text-center">
                                    <h2>Nicki Smith</h2>

                                    <div class="m-b-sm">
                                        <img alt="image" class="img-circle" src="/apply/Public/img/a2.jpg"
                                             style="width: 62px">
                                    </div>
                                </div>
                 
                                <div class="col-lg-8">
                                    <h2>
                                        About me
                                    </h2>

                                    <p>
                                        <small>Project completed in <strong>60%</strong></small>
                                    </p>
                                    <div class="progress progress-striped active m-b-sm">
                                        <div style="width: 60%;" class="progress-bar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="client-detail">
                                <div class="full-height-scroll">

                                    <div class="row">
                                        <div class="col-lg-5">
                                            <dl class="dl-horizontal">
                                                <dt>Created by:</dt> <dd>Alex_Smith</dd>
                                                <dt>Messages:</dt> <dd>  162</dd>
                                            </dl>
                                        </div>
                                        <div class="col-lg-7" id="cluster_info">
                                            <dl class="dl-horizontal" >
                                                <dt>Last Updated:</dt> <dd>16.08.2014 12:15:57</dd>
                                                <dt>Created:</dt> <dd>  10.07.2014 23:36:57 </dd>
                                            </dl>
                                        </div>
                                    </div>

    								<div class="row">
    					                <div class="col-lg-10 col-lg-offset-1">
    					                    <h4 class="text-center m">
    					                        Activity playbill
    					                    </h4>

    					                    <div class="slick_demo_2">
    					                        <div>
    					                            <div class="ibox-content">
    					                                <img src="/apply/Public/img/gallery/1s.jpg">
    					                            </div>
    					                        </div>
    					                        <div>
    					                            <div class="ibox-content">
    					                                <img src="/apply/Public/img/gallery/2s.jpg">
    					                            </div>
    					                        </div>
    					                        <div>
    					                            <div class="ibox-content">
    					                                <img src="/apply/Public/img/gallery/3s.jpg">
    					                            </div>
    					                        </div>
    					                        <div>
    					                            <div class="ibox-content">
    					                                <img src="/apply/Public/img/gallery/4s.jpg">
    					                            </div>
    					                        </div>
    					                    </div>
    					                </div>
    				                </div>

                                    <h5>Basic left float timeline</h5>
    								<div class="ibox-content inspinia-timeline">

    			                        <div class="timeline-item">
    			                            <div class="row">
    			                                <div class="col-xs-3 date">
    			                                    <i class="fa fa-check"></i>
    			                                    6:00 am
    			                                    <br/>
    			                                    <small class="text-navy">2 hour ago</small>
    			                                </div>
    			                                <div class="col-xs-7 content no-top-border">
    			                                    <p class="m-b-xs"><strong>Meeting</strong></p>

    			                                    <p>web app.</p>
    			                                </div>
    			                            </div>
    			                        </div>
    			                        <div class="timeline-item">
    			                            <div class="row">
    			                                <div class="col-xs-3 date">
    			                                    <i class="fa fa-times"></i>
    			                                    7:00 am
    			                                    <br/>
    			                                    <small class="text-navy">3 hour ago</small>
    			                                </div>
    			                                <div class="col-xs-7 content">
    			                                    <p class="m-b-xs"><strong>Send documents to Mike</strong></p>
    			                                    <p>hello world.</p>
    			                                </div>
    			                            </div>
    			                        </div>
    			                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            <div class="footer">
                <div class="pull-right">
                    10GB of <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> Example Company &copy; 2014-2015
                </div>
            </div>

        </div>
        </div>

    <!-- Mainly scripts -->
    <script src="/apply/Public/js/jquery-2.1.1.js"></script>
    <script src="/apply/Public/js/bootstrap.min.js"></script>
    <script src="/apply/Public/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/apply/Public/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/apply/Public/js/inspinia.js"></script>
    <script src="/apply/Public/js/plugins/pace/pace.min.js"></script>


</body>

</html>
<script src="/apply/Public/js/plugins/slick/slick.min.js"></script>
<!-- blueimp gallery -->
<script src="/apply/Public/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<script>

    $('.slick_demo_2').slick({
        infinite: true, // 循环播放
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: true,
        // responsive: [
        //     {
        //         breakpoint: 1024,
        //         settings: {
        //             slidesToShow: 3,
        //             slidesToScroll: 3,
        //             infinite: true,
        //             dots: true
        //         }
        //     },
        //     {
        //         breakpoint: 600,
        //         settings: {
        //             slidesToShow: 2,
        //             slidesToScroll: 2
        //         }
        //     },
        //     {
        //         breakpoint: 480,
        //         settings: {
        //             slidesToShow: 1,
        //             slidesToScroll: 1
        //         }
        //     }
        // ]
    });

</script>