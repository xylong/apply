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
<script src="/apply/Public/home/js/jquery.form.js"></script>
<style>
    .textNote{
        padding:0 5px;
    }
    .textNote textarea{
        width:100%;
    }
</style>
<div id="content">
    <div class="material_form_box">
        <table class="table">
            <caption align="center">四川大学学生活动场地、展板申请表</caption>
            <tr>
                <td width="25%"><span>活动主题</span></td>
                <td width="25%">
                    <div class="titleBox themeBox">
                        <input type="text" name="theme" id="theme" placeholder="请输入" value="<?php echo ($data["theme"]); ?>" <?php if($data['theme']): ?>readonly<?php endif; ?>>
                    </div>
                </td>
                <td width="25%"><span>申请时间</span></td>
                <td width="25%">
                    <div class="titleBox">
                        <?php if($data['apply_time']): ?><input type="text" name="apply" disabled value="<?php echo ($data["apply_time"]); ?>">
                        <?php else: ?>
                            <input type="text" name="apply" disabled id="apply" placeholder="请输入"><?php endif; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="25%"><span>申请单位</span></td>
                <td width="25%">
                    <div class="titleBox">
                        <input type="text" name="employer" class="Wdate" id="employer" value="<?php echo ($unit); ?>" readonly>
                    </div>
                </td>
                <td width="25%"><span>申请人及联系方式</span></td>
                <td width="25%">
                    <div class="titleBox">
                        <input type="text" name="applicant" id="applicant" placeholder="请输入" value="<?php echo ($data["phone"]); ?>" <?php if($data['phone']): ?>readonly<?php endif; ?>>
                    </div>
                </td>
            </tr>
            <tr>
                <td><span>使用数量</span></td>
                <td colspan="2">
                    <div class="titleBox">
                        <input type="text" name="useNum" id="useNum" placeholder="请输入" value="<?php echo ($data["number"]); ?>" <?php if($data['number']): ?>readonly<?php endif; ?>>
                    </div>
                </td>
                <td rowspan="3">
                    <?php if($data['img']): ?><div class="uploadBox w400 poster">
                            <?php if(is_array($data['img'])): $i = 0; $__LIST__ = $data['img'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?><div class="imgBox">
                                    <img src="/apply/Public/Uploads/<?php echo ($img); ?>" alt="">
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="uploadBox w400 poster">
                        </div>
                        <form action="<?php echo U('Index/uploadPoster');?>" id="posterForm" method="post" enctype="multipart/form-data">
                            <div class="upload">
                                <span id="posterText">海报照片</span>
                                <input type="file" name="pic" id="posterUpload" class="uploadInput">
                            </div>
                        </form><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><span>开始时间</span></td>
                <td colspan="2">
                    <div class="titleBox">
                        <?php if($data['stime']): ?><input type="text" class="inputUserTime" value="<?php echo ($data["stime"]); ?>" readonly>
                        <?php else: ?>
                            <input type="text" class="inputUserTime" name="startTime" id="startTime" placeholder="请选择"><?php endif; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><span>结束时间</span></td>
                <td colspan="2">
                    <div class="titleBox">
                        <?php if($data['stime']): ?><input type="text" class="inputUserTime" value="<?php echo ($data["etime"]); ?>" readonly>
                        <?php else: ?>
                            <input type="text" class="inputUserTime" name="endTime" id="endTime" placeholder="请选择"><?php endif; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><span>摆放地点</span></td>
                <td colspan="2">
                    <div class="titleBox">
                        <input type="text" name="place" id="place" placeholder="请输入" value="<?php echo ($data["place"]); ?>" <?php if($data['place']): ?>readonly<?php endif; ?>>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <?php if(!$data['download']): ?><div class="siteTitle">
                            <div class="uploadBox zipText">
                            </div>
                            <form action="<?php echo U('Index/applySite');?>" id="applyForm" method="post" enctype="multipart/form-data">
                                <div class="upload">
                                    <span>活动策划<i>(上传)</i></span>
                                    <input type="file" name="event_plan" class="uploadInput">
                                </div>
                            </form>
                        </div><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><span>备注</span></td>
                <td colspan="3">
                    <div class="textNote">
                    <?php if($data['remark']): ?><textarea name="noteText" id="note" cols="30" rows="10" placeholder="请输入" readonly><?php echo ($data["remark"]); ?></textarea></div>
                    <?php else: ?>
                        <textarea name="noteText" id="note" cols="30" rows="10" placeholder="请输入" ></textarea></div><?php endif; ?>
                </td>
            </tr>

            <?php if(!$data['id']): echo ($data["id"]); ?>
                <tr>
                    <td colspan="4">
                        <div class="save">
                            <input class="submit" type="button" value="提交">
                        </div>
                    </td>
                </tr><?php endif; ?>
        </table>


        <?php if($data['id']): ?><link rel="stylesheet" type="text/css" href="/apply/Public/home/css/index-debug.css">
            <link rel="stylesheet" type="text/css" href="/apply/Public/home/css/index.css">
            <link rel="stylesheet" type="text/css" href="/apply/Public/home/css/jquery.step.css">
            <div class="step-body" id="myStep">
                <div class="step-content">
                    <div class="step-list" style="display: block;">
                        <div class="page-panel-title">
                                <h3 class="page-panel-title-left">流程说明</h3>
                                <h3 class="page-panel-title-right">注：黄色为未审核红色为拒绝</h3>
                        </div>
                        <div class="intro-flow">

                            <?php if(is_array($progress)): $i = 0; $__LIST__ = $progress;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><div class="intro-list <?php if($data[$p['field'][0]] != 1): ?>intro-list-active<?php endif; ?>" >
                                    <div class="intro-list-left">
                                        <?php echo ($p["name"]); ?> <p><?php echo ($data[$p['field'][2]]); ?></p>
                                    </div>
                                    <div class="intro-list-right">
                                        <span><?php echo ($i); ?></span>
                                        <div class="intro-list-content">
                                            <?php if($data[$p['field'][1]]): echo ($data[$p['field'][1]]); ?>
                                            <?php else: ?>
                                                <font color="#ccc">未审核</font><?php endif; ?>
                                            &nbsp;
                                        </div>
                                    </div>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                        <div class="footer-btn">
                            <div class="common-btn">
                            </div>
                        </div>

                    </div>
                    <div class="step-list">
                        <div class="footer-btn">
                            <div class="common-btn">
                            </div>
                        </div>

                    </div>
                    <div class="step-list">
                        <div class="apply-finish">
                            <div class="apply-finish-header">
                                <img src="success.png">
                                <div class="apply-finish-msg">恭喜您，提交成功！</div>
                            </div>
                            <div class="apply-finish-footer">
                                <p>尊敬的用户，您已提交成功，受理编号为<span id="proNo">LS23423432</span>。</p>
                                <p><a href="http://www.jq22.com/demo/guide-step20160118/demo-step.html">查看单独demo</a></p>
                            </div>
                        </div>
                    </div>

                </div>

            </div><?php endif; ?>


    </div>
</div>
<script>
    $(function(){
        show.seal();
        show.setStarTime($('#apply'));

        (function(){
            if($('.imgBox').length==0){
                $('.poster').hide();
            }
        })();

        var imgs = [];

        $("input[name='event_plan']").change(function () {
            var $tmp_name = $(this).val();
            $('.zipText').text($tmp_name);
        });

        // 上传图片;
        $('#posterUpload').on('change',function(){
            var text = $('#posterText');
            $('#posterForm').ajaxSubmit({
                dataType:'json',
                beforeSend: function() {
                    text.html("上传中...");
                },
                success: function(data) {
                    var src=data.src,code=data.code,html='';
                    imgs.push(data.src);
                    html += '<div class="imgBox">';
                    html += '<img src="/apply/Public/Uploads' + '/' + src + '" data-code="' + code + '" alt="">';
                    html += '<p class="closeImg"><tt class="shu"></tt>';
                    html += '<tt class="hen"></tt></p>';
                    html += '</div>';
                    $('.poster').show().append(html);
                    text.html("海报照片");
                },
                error: function(xhr) {
                    text.html("上传失败");
                }
            })
        });

        // 删除海报
        $('body').on('click','.closeImg',function(){
            var self = $(this),
                src = self.parents('.imgBox').find('img').attr('src');

            // 从提交的图片地址中剔除删除的地址
            for (var i = 0; i < imgs.length; i++) {
                if (src.indexOf(imgs[i]) > 0) {
                    imgs.splice(i, 1);
                }
            }

            $.post("<?php echo U('Index/delPoster');?>",{
                src : src
            },function(data){
                $(self).parents('.imgBox').remove();
            })
        });

        $('#startTime').click(function(){
            var start = new Dates({
                id:'startTime',
                sTime:false
            });
            start.init();
        });
        $('#endTime').click(function(){
            var end = new Dates({
                id:'endTime',
                sTime:false
            });
            end.init();
        });
        $('.save .submit').click(function(){
            var form = new FormData(document.getElementById("applyForm")),
                self = $(this);
            if (self.hasClass('disabled'))
                return false;

            var theme = $('#theme').val(),
                employer = $('#employer').val(),
                applicant = $('#applicant').val(),
                useNum = $('#useNum').val(),
                place = $('#place').val(),
                start = {
                    time:$('#startTime').attr('time'),
                    id:$('#startTime').attr('sid')
                },
                end = {
                    time:$('#endTime').attr('time'),
                    id:$('#endTime').attr('sid')
                },
                noteText = $('#note').val();

            if(theme==''||employer==''||start.time==undefined||start.id==undefined||end.time==undefined||end.id==undefined||applicant==''||useNum==''||place==''||imgs.length==0)
                return show.info('请完善信息');
            if ($("input[name='event_plan']").val() == '') {
                return show.info('请上传活动策划');
            }
            if(parseInt(start.time)>parseInt(end.time)||(parseInt(start.time)==parseInt(end.time)&&parseInt(start.id)>parseInt(end.id)))
                return show.info('开始时间应该小于结束时间,请重新选择');
            if(!(/^1[3|4|5|7|8]\d{9}$/.test(applicant)))
                return show.info('请输入正确手机号');

            var start_time = start.time + ',' + start.id;
            var end_time = end.time + ',' + end.id;

            form.append('theme', theme);
            form.append('unit', employer);
            form.append('phone', applicant);
            form.append('number', useNum);
            form.append('place', place);
            form.append('stime', start_time);
            form.append('etime', end_time);
            form.append('board', imgs);
            form.append('remark', noteText);
            $.ajax({
                url:"<?php echo U('Index/applySite');?>",
                type:"post",
                data:form,
                processData:false,
                contentType:false,
                dataType:'json',
                success:function(data){
                    if (data.status) {
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    }
                    show.info(data.info);
                },
                error:function(e){
                }
            });
        });
    })
</script>