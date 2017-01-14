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
<script src="/apply/Public/home/js/time/My97DatePicker/WdatePicker.js"></script>
<script src="/apply/Public/home/js/vue.js"></script>
<script src="/apply/Public/home/js/jquery.twbsPagination.js" charset="utf-8"></script>


<div id="content">
    <p class="c-title">申请列表</p>
    <div class="c-header">
        <form action="">
            <div class="search">
               <label>
                    <span>类型 : </span>
                    <select v-model="selected" @change="tab">
                        <option v-for="option in types" v-bind:value="option.id">
                        {{option.name}}
                        </option>                  
                    </select>
                </label>
            </div>
        </form>
    </div>
    <div id="application-list">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th>申请码</th>
                    <th>申请时间</th>
                    <th>查看二维码</th>
                    <th>查看</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in apply">
                    <td>{{item.apply_code}}</td>
                    <td>{{item.apply_time}}</td>
                    <td><a href="{{item.downqr}}">下载二维码</a></td>
                    <td><a href="{{item.url}}" target="_balnk">查看</a></td>
                </tr>
            </tbody>
        </table>
        <div id="page"></div>
    </div>
</div>

<script>
    var apply = new Vue({
        el : '#content',

        data : {
            types : [],
            selected : 0,
            apply : [],
            visiblePages : '',
        },

        methods : {
            init : function () {
                $.get("<?php echo U('Index/getApplyType');?>", function (data) {
                    if (data.status) {
                        apply.types = data.data;
                    }
                }, 'json');
            },

            // 数据分页
            page : function (pageid = 1) {
                $.get("<?php echo U('Index/index');?>", {
                    type : this.selected,
                    pageid : localStorage.page
                }, function (data) {
                    if (data.status) {
                        apply.apply = data.data.data;
                        apply.visiblePages = data.data.count;

                        $('#page').twbsPagination({
                            totalPages: apply.visiblePages,
                            visiblePages: apply.visiblePages,
                            version: '1.1',
                            onPageClick: function(event, page) {
                                localStorage.page = page;
                                apply.page(apply.type, page);
                                $('#page-content').text('Page ' + page);
                            }
                        });
                    }
                }, 'json');
            },


            // 切换申请分类
            tab : function () {
                $('#page').remove();
                $('#application-list').append('<div id="page"></div>');
                this.page();
            },



        },

        ready : function () {
            this.selected = 1;
            this.page();
            this.init();
        }
    });
</script>