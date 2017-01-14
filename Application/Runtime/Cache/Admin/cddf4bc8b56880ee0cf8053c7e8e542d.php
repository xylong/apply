<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>hAdmin</title>

    <link rel="shortcut icon" href="favicon.ico">
    <link href="/apply/Public/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/apply/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/apply/Public/css/animate.css" rel="stylesheet">
    <link href="/apply/Public/css/style.css?v=4.1.0" rel="stylesheet">

</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">

    <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="slimScrollDiv" style="position: relative; width: auto; height: 100%;">
                <div class="sidebar-collapse" style="width: auto; height: 100%;">
                    <ul class="nav" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear">
                                        <span class="block m-t-xs" style="font-size:20px;">
                                            <i class="fa fa-area-chart"></i>
                                            <strong class="font-bold"><?php echo (session('username')); ?></strong>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div class="logo-element">hAdmin
                            </div>
                        </li>

                        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                            <span class="ng-scope">分类</span>
                        </li>
                        <li>
                            <a class="J_menuItem" href="<?php echo U('Apply/welcome');?>">
                                <i class="fa fa-home"></i>
                                <span class="nav-label">主页</span>
                            </a>
                        </li>

                        

                        

                        
                        
                        <?php if(is_array($_SESSION['auth'])): $i = 0; $__LIST__ = $_SESSION['auth'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$auth): $mod = ($i % 2 );++$i; if($auth == 1): ?><li>
                                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">申请</span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level collapse">
                                        <li><a class="J_menuItem" href="<?php echo U('Borrow/lists');?>">物资</a>
                                        </li>
                                        <li><a class="J_menuItem" href="<?php echo U('Workshop/lists');?>">青春工坊</a>
                                        </li>
                                        <li><a class="J_menuItem" href="<?php echo U('Venue/lists');?>">展场展架</a>
                                        </li>
                                    </ul>
                                </li><?php endif; ?>
                            <?php if($auth == 2): ?><li>
                                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">物资管理</span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level collapse">
                                        <li><a class="J_menuItem" href="<?php echo U('Material/index');?>">物资</a></li>
                                    </ul>
                                </li><?php endif; ?>
                            <?php if($auth == 3): ?><li>
                                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">青春工坊管理</span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level collapse">
                                        <li><a class="J_menuItem" href="<?php echo U('Young/index');?>">工坊管理</a></li>
                                    </ul>
                                </li><?php endif; ?>
                            <?php if($auth == 4): ?><li>
                                    <a href="#"><i class="fa fa-group"></i> <span class="nav-label">用户管理</span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level collapse">
                                        <li><a class="J_menuItem" href="<?php echo U('Group/college');?>">学院/组织</a></li>
                                        <li><a class="J_menuItem" href="<?php echo U('Applicant/lists');?>">用户</a></li>
                                        <li><a class="J_menuItem" href="<?php echo U('User/administrator');?>">管理员</a></li>
                                        <li><a class="J_menuItem" href="<?php echo U('Rbac/roleList');?>">角色列表</a></li>
                                    </ul>
                                </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>

                        <!-- <li>
                            <a href="#"><i class="fa fa-group"></i> <span class="nav-label">权限管理</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a class="J_menuItem" href="<?php echo U('Rbac/roleList');?>">角色列表</a></li>
                                <li><a class="J_menuItem" href="<?php echo U('Rbac/tree');?>">权限节点</a></li>
                            </ul>
                        </li> -->

                    </ul>
                </div>
                <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 4px; position: absolute; top: 288px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 950px;"></div>
                <div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.9; z-index: 90; right: 1px;"></div>
            </div>
        </nav>
        <!--左侧导航结束-->

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-info " href="#"><i class="fa fa-bars"></i> </a>
                        <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="javascript:;">
                                <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
                            </a>
                            <!-- <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    <a href="mailbox.html">
                                        <div>
                                            <i class="fa fa-envelope fa-fw"></i> 您有16条未读消息
                                            <span class="pull-right text-muted small">4分钟前</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="profile.html">
                                        <div>
                                            <i class="fa fa-qq fa-fw"></i> 3条新回复
                                            <span class="pull-right text-muted small">12分钟钱</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a class="J_menuItem" href="notifications.html">
                                            <strong>查看所有 </strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul> -->
                        </li>
                        <li class="dropdown">
                            <button class="btn btn-info  dim" type="button" onclick="logout()"><i class="fa fa-sign-out"></i></button>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row J_mainContent" id="content-main">
<script>
    function logout() {
        window.location.href = "<?php echo U('Login/logout');?>";
    }
</script>
            <iframe id="J_iframe" width="100%" height="100%" src="<?php echo ($template); ?>" frameborder="0" ></iframe>

<iframe id="J_iframe" width="100%" height="100%" src="<?php echo ($template); ?>" frameborder="0" ></iframe>

            </div>
        </div>
    

    <!-- 全局js -->
    <script src="/apply/Public/js/jquery.min.js?v=2.1.4"></script>
    <script src="/apply/Public/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/apply/Public/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/apply/Public/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/apply/Public/js/plugins/layer/layer.min.js"></script>

    <!-- 自定义js -->
    <script src="/apply/Public/js/hAdmin.js?v=4.1.0"></script>
    <script type="text/javascript" src="/apply/Public/js/index.js"></script>



</body>
</html>