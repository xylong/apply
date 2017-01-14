<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Leagua</title>
	<link rel="stylesheet" href="/apply/Public/home/css/style.css">
	<link rel="stylesheet" href="/apply/Public/home/css/basic.css">
	<link rel="stylesheet" href="/apply/Public/home/js/dates/dates.css">
	<script src="/apply/Public/home/js/jquery-2.2.4.min.js"></script>
	<script src="/apply/Public/home/js/basic.js"></script>
	<script src="/apply/Public/home/js/dates/dates.js"></script>
</head>
<body>
    <!--header-->
    <div id="header">
        <div class="userBox">
			<p class="user"><span><?php echo session('nickname');?></span><a href="<?php echo U('Admin/Apply/index');?>">后台</a>&nbsp;&nbsp;<a href="<?php echo U('Login/logout');?>">退出</a></p>
		</div>
    </div>
    <!--leftNav-->
    <div id="left-nav">
	    <ul>
	        <li <?php if($menu_action == 'index'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/index');?>">申请列表</a></li>
	        <li class="application">
	            <span>申请</span>
	            <ul class="app-menu" <?php if(($menu_action == 'applyMaterials') OR ($menu_action == 'applyWorkshop') OR ($menu_action == 'applySite')): ?>style="display: block;"<?php endif; ?>>
	                <li <?php if($menu_action == 'applyMaterials'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/applyMaterials');?>">物资申请</a></li>
	                <li <?php if($menu_action == 'applyWorkshop'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/applyWorkshop');?>">工坊申请</a></li>
	                <li <?php if($menu_action == 'applySite'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/applySite');?>">场地申请</a></li>
	            </ul>
	        </li>
	        <li <?php if($menu_action == 'resetPwd'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/resetPwd');?>">修改密码</a></li>
	    </ul>
	</div>


    <script>
        //申请二级菜单
        $('.application span').click(function(){
            $(this).addClass('active').parent('li').siblings("li").find('span').removeClass('active');
            $(this).parent().find('.app-menu').toggle(300);
        });
        $('.app-menu li').click(function(){
            $(this).addClass("m-active").siblings('li').removeClass('m-active');
            $(this).parent().toggle(300);
        });

    </script>

<div id="content">
    <p class="c-title">修改密码</p>
    <div id="reset-pwd">
        <form action="" method="post" onsubmit="return check()">
            <label style="text-indent: 17px"><span>旧密码 : </span><input type="password" name="oldpwd" id="old-pwd"/></label>
            <p class="ts" id="old-ts"></p>
            <label style="text-indent: 17px"><span>新密码 : </span><input type="password" name="newpwd" id="new-pwd"/></label>
            <p class="ts" id="new-ts"></p>
            <label><span>确认密码 : </span><input type="password" name="repwd" id="sure-pwd"/></label>
            <p class="ts" id="surePwd-ts"></p>
            <input type="submit" value="提交"/>
        </form>
    </div>
</div>

<script>
    function check(){
        var oldPwd = $('#old-pwd').val();
        var newPwd = $('#new-pwd').val();
        var surePwd = $('#sure-pwd').val();
        var flag = true;
        if(oldPwd== "" || oldPwd.length < 6){
            $('#old-ts').html("旧密码有误");
            flag = false;
        }else{
            $('#old-ts').html("");
            flag = true
        }
        if(newPwd== "" || newPwd.length <6){
            $('#new-ts').html("新密码长度不能小于6位");
            flag = false;
        }else{
            $('#new-ts').html("");
            flag = true
        }
        if(surePwd== "" || surePwd.length <6){
            $('#surePwd-ts').html("确认密码长度不能小于6位");
            flag = false;
        }else if(surePwd != newPwd){
            $('#surePwd-ts').html("两次密码输入不一致!");
            flag = false;
        }else{
            $('#surePwd-ts').html("");
            flag = true
        }
        if(flag == false){
            return false;
        }else{
            return true;
        }
    }
</script>